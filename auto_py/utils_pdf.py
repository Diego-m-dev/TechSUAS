import os
import re
from pdf2image import convert_from_path
import pytesseract
from datetime import datetime
from pathlib import Path

# Caminho do executável do Tesseract
pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'
poppler_path = r"C:\poppler\Library\bin"

def extrair_texto_pdf(pdf_path):
    texto_total = ""
    try:
        paginas = convert_from_path(pdf_path, dpi=300, poppler_path=poppler_path)
        for i, pagina in enumerate(paginas):
            texto = pytesseract.image_to_string(pagina, lang='por')
            print(f"\n--- Página {i+1} ---")
            print("Texto extraído:", texto[:300])  # Mostra só os 300 primeiros caracteres
            texto_total += texto + "\n"
    except Exception as e:
        print(f"❌ Erro ao extrair texto de {pdf_path}: {e}")
        raise
    return texto_total

def extrair_codigo_familiar_e_data(texto):
    try:
        match = re.search(
            r"Código\s+Fam[\wííl]{4,8}:\s*([A-Z0-9\-]+).*?Data\s+da\s+Entrevista:\s*(\d{2}/\d{2}/\d{4})",
            texto,
            re.IGNORECASE | re.DOTALL
        )
        if match:
            codigo = match.group(1).replace("-", "").strip()
            data = match.group(2).replace("/", "").strip()
            return codigo, data
        else:
            print("❌ Erro ao extrair código e data: Padrão não encontrado no texto.")
            return None, None
    except Exception as e:
        print(f"❌ Erro inesperado ao extrair código e data: {e}")
        return None, None

def gerar_nome_arquivo(codigo, data, tipo_fixo="2"):
    return f"{codigo}-{data}-1-{tipo_fixo}"

def extrair_dados_folha_resumo(pdf_path):
    print(f"\n📂 Processando: {pdf_path}")
    try:
        texto = extrair_texto_pdf(pdf_path)
        codigo, data = extrair_codigo_familiar_e_data(texto)
        novo_nome = gerar_nome_arquivo(codigo, data)
        print(f"📄 Nome sugerido: {novo_nome}.pdf")

        # Caminho final
        nova_path = os.path.join(os.path.dirname(pdf_path), f"{novo_nome}.pdf")

        # Renomear
        os.rename(pdf_path, nova_path)
        print(f"✅ Arquivo renomeado para: {nova_path}")

        return {"status": "ok", "novo_nome": novo_nome}

    except Exception as e:
        print(f"❌ Erro ao processar {os.path.basename(pdf_path)}: {e}")
        return {"status": "erro", "mensagem": str(e), "arquivo": pdf_path}
