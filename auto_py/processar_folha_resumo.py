import pdfplumber
import re
import requests
import shutil
from datetime import datetime
import os

# Configurações
URL_DADOS = "https://techsuas.com/TechSUAS/api/upload_folha_resumo.php"
TOKEN_AUTENTICACAO = "#uploadTech@2025!"

PASTA_MONITORADA = r"C:\uploads_entrevistas"
PASTA_ENVIADOS = os.path.join(PASTA_MONITORADA, "enviados")
PASTA_ERROS = os.path.join(PASTA_MONITORADA, "erro_logs")
LOG_FILE = os.path.join(PASTA_MONITORADA, "log_upload.txt")

MAPA_PARENTESCO = {
    "RESPONSÁVEL FAMILIAR": "1",
    "CÔNJUGE OU COMPANHEIRO(A)": "2",
    "CÔNJUGE": "2",
    "FILHO(A)": "3",
    "ENTEADO(A)": "4",
    "NETO OU BISNETO": "5",
    "NETO(A) OU BISNETO(A)": "5",
    "PAI OU MAE": "6",
    "SOGRO(A)": "7",
    "IRMAOS OU IRMA": "8",
    "GENRO OU NORA": "9",
    "OUTRO PARENTE": "10",
    "NAO PARENTE": "11"
}

def registrar_log(mensagem):
    with open(LOG_FILE, "a", encoding="utf-8") as log:
        log.write(f"[{datetime.now().strftime('%d/%m/%Y %H:%M:%S')}] {mensagem}\n")

def extrair_valor(ini, texto, fim=None):
    padrao = re.escape(ini) + r"(.*?)(?:" + re.escape(fim) + r"|$)" if fim else re.escape(ini) + r"(.*)"
    resultado = re.search(padrao, texto, re.DOTALL)
    return resultado.group(1).strip().replace("\n", " ") if resultado else ""

def identificar_parentesco(texto):
    texto = texto.replace("COM RESPONSÁVEL", "").strip().upper()
    for chave, valor in MAPA_PARENTESCO.items():
        if chave in texto:
            return valor
    return "11"  # NAO PARENTE

def limpar_cpf(cpf):
    return re.sub(r'\D', '', cpf).lstrip("0")

def extrair_componentes(texto):
    membros = []
    blocos = re.split(r"4\.02 - Nome Completo:", texto)

    parentesco_buffer = None  # Armazena o parentesco encontrado

    for i in range(1, len(blocos)):
        bloco = blocos[i]

        # Captura o parentesco do bloco anterior (antes do próximo 4.02)
        parentesco_match = re.search(r"4\.07 - Parentesco com Responsável\s*(.*)", blocos[i - 1])
        if parentesco_match:
            parentesco_raw = parentesco_match.group(1).strip().upper()
            parentesco_buffer = identificar_parentesco(parentesco_raw)
        else:
            parentesco_buffer = "1" if i == 1 else "11"  # Primeiro é sempre RF, outros como "não parente" por padrão

        nome = bloco.split("5.02 - CPF:")[0].strip()
        cpf_match = re.search(r"5\.02 - CPF:\s*([\d\.\-]+)", bloco)
        nasc_match = re.search(r"4\.08 - Data de Nascimento:\s*(\d{2}/\d{2}/\d{4})", bloco)

        if not nome or not cpf_match or not nasc_match:
            registrar_log(f"[⚠️] Dados incompletos ignorados. Nome: {nome}")
            continue

        cpf = limpar_cpf(cpf_match.group(1))
        nascimento = datetime.strptime(nasc_match.group(1), "%d/%m/%Y").strftime("%Y-%m-%d")

        membros.append({
            "nome": nome,
            "cpf": cpf,
            "nascimento": nascimento,
            "parentesco": parentesco_buffer
        })

    return membros


def processar_folha_resumo(caminho_arquivo, nome_arquivo, cpf_operador, nome_operador=None):
    try:
        texto = ""
        with pdfplumber.open(caminho_arquivo) as pdf:
            for pagina in pdf.pages:
                texto += pagina.extract_text() + "\n"

        # with open(os.path.join(PASTA_ERROS, f"{nome_arquivo}_conteudo.txt"), "w", encoding="utf-8") as f:
        #     f.write(texto)

        registrar_log(f"[DEBUG] TEXTO EXTRAÍDO:\n{texto[:1000]}...")

        membros = extrair_componentes(texto)
        registrar_log(f"[DEBUG] MEMBROS EXTRAÍDOS: {membros}")
        if not membros:
            raise ValueError("Nenhum membro da família encontrado.")

        cod_fam_match = re.search(r"1\.01 Código familiar:\s*(\d+)", texto)
        if not cod_fam_match:
            raise ValueError("Código familiar não encontrado.")
        cod_fam = cod_fam_match.group(1).zfill(11)
        registrar_log(f"[DEBUG] Código Familiar: {cod_fam}")

        referencia_raw = extrair_valor("1.20 - Referência para Localização:", texto, "III - COMPONENTES")
        referencia_limpa = re.split(r'\d{1,2}\.02', referencia_raw)[0].strip()

        data_match = re.search(r"1\.10 Data da entrevista:\s*(\d{2}/\d{2}/\d{4})", texto)
        if not data_match:
            raise ValueError("Data da entrevista não encontrada.")
        data_entrevista_iso = datetime.strptime(data_match.group(1), "%d/%m/%Y").strftime("%Y-%m-%d")
        registrar_log(f"[DEBUG] Data da Entrevista: {data_entrevista_iso}")

        renda_txt = extrair_valor("RENDA PER CAPITA DA FAMÍLIA:", texto, "II - ENDEREÇO")
        try:
            renda_int = int(float(renda_txt))  # Converte "0.0" → 0
        except:
            renda_int = 0

        dados_endereco = {
            "vlr_renda_media_fam": renda_int,
            "nom_localidade_fam": extrair_valor("1.11 - Localidade:", texto, "1.12 - Tipo:"),
            "nom_tip_logradouro_fam": extrair_valor("1.12 - Tipo:", texto, "1.13 - Título:"),
            "nom_titulo_logradouro_fam": extrair_valor("1.13 - Título:", texto, "1.14 - Nome:"),
            "nom_logradouro_fam": extrair_valor("1.14 - Nome:", texto, "1.15 - Número:"),
            "num_logradouro_fam": extrair_valor("1.15 - Número:", texto, "1.16 - Complemento do Número:") or "0",
            "des_complemento_fam": extrair_valor("1.16 - Complemento do Número:", texto, "1.17 - Complemento Adicional:"),
            "des_complemento_adic_fam": extrair_valor("1.17 - Complemento Adicional:", texto, "1.18 - Cep:"),
            "num_cep_logradouro_fam": extrair_valor("1.18 - Cep:", texto, "1.20 - Referência"),
            "txt_referencia_local_fam": referencia_limpa,
        }
        registrar_log(f"[DEBUG] ENDEREÇO EXTRAÍDO: {dados_endereco}")

        for membro in membros:
            dados = {
                "token": TOKEN_AUTENTICACAO,
                "num_cpf_pessoa": membro["cpf"],
                "cod_familiar_fam": cod_fam,
                "dta_entrevista_fam": data_entrevista_iso,
                "dat_atual_fam": data_entrevista_iso,
                "nom_pessoa": membro["nome"],
                "dta_nasc_pessoa": membro["nascimento"],
                "cod_parentesco_rf_pessoa": membro["parentesco"],
                "qtde_meses_desat_cat": "0",
                "nom_entrevistador_fam": nome_operador,
                "num_cpf_entrevistador_fam": cpf_operador.lstrip("0"),
                **dados_endereco
            }

            registrar_log(f"📤 Enviando dados para API: {dados}")
            response = requests.post(URL_DADOS, data=dados)
            registrar_log(f"📩 Resposta da API: {response.text}")

            response.raise_for_status()
            json_resp = response.json()

            if json_resp.get("salvo") is True:
                registrar_log(f"✅ Enviado com sucesso - CPF: {membro['cpf']}")
            else:
                raise Exception(json_resp.get("erro") or json_resp.get("mensagem") or "Erro desconhecido.")

        shutil.move(caminho_arquivo, os.path.join(PASTA_ENVIADOS, nome_arquivo))

    except Exception as e:
        registrar_log(f"❌ Erro ao processar {nome_arquivo}: {str(e)}")
        shutil.move(caminho_arquivo, os.path.join(PASTA_ERROS, nome_arquivo))
