import os
import time
import shutil
import threading
import requests
from datetime import datetime
from watchdog.observers import Observer
from watchdog.events import FileSystemEventHandler
import tkinter as tk
from tkinter import messagebox
from processar_folha_resumo import processar_folha_resumo

# Configurações
PASTA_MONITORADA = r"C:\uploads_entrevistas"
PASTA_ENVIADOS = os.path.join(PASTA_MONITORADA, "enviados")
PASTA_ERROS = os.path.join(PASTA_MONITORADA, "erro_logs")
LOG_FILE = os.path.join(PASTA_MONITORADA, "log_upload.txt")
URL_UPLOAD = "https://techsuas.com/TechSUAS/api/upload_automacao_api.php"
TOKEN_AUTENTICACAO = "#uploadTech@2025!"

OPERADORES = {
    "71418124400": "MARIA RAFAELLA DE MELO COSTA ALVES",
    "13408711496": "DIEGO MOREIRA DE ANDRADE",
    "12490721402": "MARIA EDUARDA DE FARIAS MORAES",
    "11278024450": "HAMILTON SERGIO DE ASSIS FILHO",
    "10483997455": "MARIA WILLIANE SILVA MONTEIRO SANTOS",
    "10314826440": "CARLA LETICIA CARNEIRO DO CARMO",
    "09234987454": "DIEGO EMMANUEL CADETE",
    "09067685437": "NAILDA MIRELY ALMEIDA MORAES DA SILVA",
    "08694016451": "DAVID CATONHO DE MELO",
    "06453366452": "IGOR RAMON GOMES DE AZEVEDO",
    "05917886407": "RENATO ANDRADE DE LIMA",
    "12094532402": "ILAIANE OLIVEIRA DA SILVA",
}

os.makedirs(PASTA_ENVIADOS, exist_ok=True)
os.makedirs(PASTA_ERROS, exist_ok=True)

def registrar_log(mensagem):
    with open(LOG_FILE, "a", encoding="utf-8") as log:
        log.write(f"[{datetime.now().strftime('%d/%m/%Y %H:%M:%S')}] {mensagem}\n")

def processar_upload_padrao(caminho_arquivo, nome_arquivo, nome_operador):
    try:
        partes = nome_arquivo.replace(".pdf", "").split("-")
        if len(partes) != 4:
            raise ValueError("Formato do nome inválido. Esperado: CODIGO-DATA-SIT-TIPO")

        cod_fam, data_entrevista, sit_beneficio, tipo_documento = partes
        data_formatada = datetime.strptime(data_entrevista, "%d%m%Y").strftime("%Y-%m-%d")

        with open(caminho_arquivo, "rb") as f:
            files = {"arquivo": (nome_arquivo, f, "application/pdf")}
            data = {
                "token": TOKEN_AUTENTICACAO,
                "cod_fam": cod_fam,
                "data_entrevista_hoje": data_formatada,
                "sit_beneficio": sit_beneficio,
                "tipo_documento": tipo_documento,
                "operador": nome_operador
            }

            response = requests.post(URL_UPLOAD, files=files, data=data)
            response.raise_for_status()
            json_resp = response.json()

        if json_resp.get("salvo") is True:
            registrar_log(f"✔️ Enviado com sucesso: {nome_arquivo}")
            shutil.move(caminho_arquivo, os.path.join(PASTA_ENVIADOS, nome_arquivo))
        else:
            msg = json_resp.get("erro") or json_resp.get("mensagem") or "Resposta desconhecida do servidor."
            raise Exception(msg)

    except Exception as e:
        registrar_log(f"❌ Falha ao enviar {nome_arquivo}: {str(e)}")
        shutil.move(caminho_arquivo, os.path.join(PASTA_ERROS, nome_arquivo))


class MonitorHandler(FileSystemEventHandler):
    def __init__(self, cpf_operador, nome_operador, app_interface=None):
        super().__init__()
        self.cpf_operador = cpf_operador
        self.nome_operador = nome_operador
        self.app_interface = app_interface

    def on_created(self, event):
        if event.is_directory or not event.src_path.lower().endswith(".pdf"):
            return

        time.sleep(2)
        caminho_arquivo = event.src_path
        nome_arquivo = os.path.basename(caminho_arquivo)

        try:
            if nome_arquivo.startswith("Folha Resumo - Código familiar"):
                processar_folha_resumo(caminho_arquivo, nome_arquivo, self.cpf_operador, self.nome_operador)
                if self.app_interface:
                    self.app_interface.atualizar_historico(f"✅ Folha Resumo enviada: {nome_arquivo}")
            elif nome_arquivo.count("-") == 3:
                processar_upload_padrao(caminho_arquivo, nome_arquivo, self.nome_operador)
                if self.app_interface:
                    self.app_interface.atualizar_historico(f"✅ Documento enviado: {nome_arquivo}")
            else:
                raise ValueError("Nome de arquivo não reconhecido.")

        except Exception as e:
            registrar_log(f"❌ Erro ao processar {nome_arquivo}: {str(e)}")
            shutil.move(caminho_arquivo, os.path.join(PASTA_ERROS, nome_arquivo))
            if self.app_interface:
                self.app_interface.atualizar_historico(f"❌ Falha ao processar {nome_arquivo}: {e}")

        if self.app_interface:
            self.app_interface.atualizar_contador()


class App:
    def __init__(self, master):
        self.master = master
        master.title("Monitoramento de Uploads")

        self.status = tk.StringVar()
        self.status.set("⛔ Monitoramento parado")

        self.label = tk.Label(master, textvariable=self.status, font=("Arial", 12))
        self.label.pack(pady=10)

        self.cpf_label = tk.Label(master, text="CPF do operador:")
        self.cpf_label.pack()

        self.cpf_entry = tk.Entry(master)
        self.cpf_entry.pack(pady=5)

        self.nome_operador_var = tk.StringVar()
        self.nome_operador_label = tk.Label(master, textvariable=self.nome_operador_var, font=("Arial", 10, "italic"))
        self.nome_operador_label.pack(pady=2)

        self.iniciar_btn = tk.Button(master, text="▶️ Iniciar Monitoramento", command=self.iniciar_monitoramento)
        self.iniciar_btn.pack(pady=5)

        self.parar_btn = tk.Button(master, text="⏹ Parar Monitoramento", command=self.parar_monitoramento, state="disabled")
        self.parar_btn.pack(pady=5)

        self.historico_label = tk.Label(master, text="Histórico de Processamento:")
        self.historico_label.pack()

        self.historico_text = tk.Text(master, height=15, width=70, state='disabled')
        self.historico_text.pack(pady=5)

        self.contador_var = tk.StringVar()
        self.contador_var.set("Arquivos restantes: 0")
        self.contador_label = tk.Label(master, textvariable=self.contador_var)
        self.contador_label.pack(pady=5)

        self.observer = None
        self.thread_monitoramento = None

        self.atualizar_contador()  # Inicia atualização periódica

    def atualizar_historico(self, mensagem):
        self.historico_text.config(state='normal')
        self.historico_text.insert(tk.END, f"[{datetime.now().strftime('%H:%M:%S')}] {mensagem}\n")
        self.historico_text.see(tk.END)
        self.historico_text.config(state='disabled')

    def atualizar_contador(self):
        try:
            arquivos_pdf = [f for f in os.listdir(PASTA_MONITORADA)
                            if f.lower().endswith(".pdf") and os.path.isfile(os.path.join(PASTA_MONITORADA, f))]
            self.contador_var.set(f"Arquivos restantes: {len(arquivos_pdf)}")
        except Exception as e:
            self.contador_var.set(f"Erro ao contar arquivos: {str(e)}")
        self.master.after(5000, self.atualizar_contador)

    def iniciar_monitoramento(self):
        cpf_operador = self.cpf_entry.get().strip()

        if not cpf_operador or len(cpf_operador) != 11 or not cpf_operador.isdigit():
            messagebox.showerror("Erro", "Digite um CPF válido com 11 dígitos.")
            return

        nome_operador = OPERADORES.get(cpf_operador)
        if not nome_operador:
            messagebox.showerror("Erro", "CPF não encontrado na lista de operadores.")
            return

        self.cpf_operador = cpf_operador
        self.nome_operador = nome_operador
        self.nome_operador_var.set(f"Operador: {self.nome_operador}")

        if not self.observer:
            registrar_log(f"🚀 Monitoramento iniciado pela interface. CPF operador: {self.cpf_operador}")
            self.status.set("✅ Monitorando...")
            self.observer = Observer()
            self.observer.schedule(MonitorHandler(self.cpf_operador, self.nome_operador, self), PASTA_MONITORADA, recursive=False)
            self.thread_monitoramento = threading.Thread(target=self.observer.start, daemon=True)
            self.thread_monitoramento.start()
            self.iniciar_btn.config(state="disabled")
            self.parar_btn.config(state="normal")
            self.atualizar_historico("🚀 Monitoramento iniciado.")
        else:
            messagebox.showinfo("Aviso", "O monitoramento já está em execução.")

    def parar_monitoramento(self):
        if self.observer:
            self.observer.stop()
            self.observer.join()
            self.observer = None
            registrar_log("🛑 Monitoramento parado pela interface.")
            self.status.set("⛔ Monitoramento parado")
            self.iniciar_btn.config(state="normal")
            self.parar_btn.config(state="disabled")
            self.atualizar_historico("🛑 Monitoramento parado.")

    def fechar(self):
        if self.observer:
            self.observer.stop()
            self.observer.join()
        self.master.destroy()


if __name__ == "__main__":
    root = tk.Tk()
    app = App(root)
    root.protocol("WM_DELETE_WINDOW", app.fechar)
    root.mainloop()
