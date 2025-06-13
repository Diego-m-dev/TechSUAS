import os
import time
import shutil
from watchdog.observers import Observer
from watchdog.events import FileSystemEventHandler
from utils_pdf import extrair_dados_folha_resumo
from datetime import datetime

PASTA_ORIGEM = r"C:\pdfs"
PASTA_DESTINO = r"C:\uploads_entrevistas"
PASTA_ERROS = r"C:\uploads_entrevistas\erro_logs"

os.makedirs(PASTA_DESTINO, exist_ok=True)
os.makedirs(PASTA_ERROS, exist_ok=True)

def renomear_folha_resumo(caminho_arquivo):
    try:
        dados = extrair_dados_folha_resumo(caminho_arquivo)

        if dados["status"] == "ok":
            nome_novo = dados["novo_nome"]
            destino = os.path.join(PASTA_DESTINO, nome_novo)

            shutil.move(caminho_arquivo, destino)
            print(f"✅ Arquivo renomeado para: {destino}")
        else:
            print(f"⚠️ Erro ao extrair dados: {dados['mensagem']}")
            # Aqui, apenas move para erro_logs se o arquivo ainda existir
            if os.path.exists(caminho_arquivo):
                shutil.move(caminho_arquivo, os.path.join(PASTA_ERROS, os.path.basename(caminho_arquivo)))
                print("📁 Arquivo movido para erro_logs.")
            else:
                print("❌ Arquivo não encontrado para mover para erro_logs.")
    except Exception as e:
        print(f"❌ Exceção ao processar {os.path.basename(caminho_arquivo)}: {e}")
        if os.path.exists(caminho_arquivo):
            try:
                shutil.move(caminho_arquivo, os.path.join(PASTA_ERROS, os.path.basename(caminho_arquivo)))
                print("📁 Arquivo movido para erro_logs.")
            except Exception as erro_move:
                print(f"❌ Falha ao mover para erro_logs: {erro_move}")
        else:
            print("❌ Arquivo não encontrado para mover para erro_logs.")

class PDFHandler(FileSystemEventHandler):
    def on_created(self, event):
        if event.is_directory or not event.src_path.lower().endswith(".pdf"):
            return

        time.sleep(2)  # espera para garantir que o arquivo terminou de ser gravado
        renomear_folha_resumo(event.src_path)

if __name__ == "__main__":
    print("🔍 Monitorando nova pasta de PDFs (pré-processamento)...")
    observer = Observer()
    observer.schedule(PDFHandler(), PASTA_ORIGEM, recursive=False)
    observer.start()

    try:
        while True:
            time.sleep(1)
    except KeyboardInterrupt:
        observer.stop()
    observer.join()
