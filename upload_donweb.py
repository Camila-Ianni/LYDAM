import os
import sys
import ssl
from ftplib import FTP_TLS
import getpass

def upload_file_ftps(ftp, local_file, remote_file):
    print(f"Subiendo {local_file} como {remote_file}...")
    file_size = os.path.getsize(local_file)
    uploaded = 0

    def progress_callback(block):
        nonlocal uploaded
        uploaded += len(block)
        percent = (uploaded / file_size) * 100
        sys.stdout.write(f"\rProgreso: {percent:.1f}% ({uploaded / (1024*1024):.2f} MB / {file_size / (1024*1024):.2f} MB)")
        sys.stdout.flush()

    with open(local_file, "rb") as f:
        ftp.storbinary(f"STOR {remote_file}", f, callback=progress_callback)
    print("\n✓ Subida completa.")

def connect_ftps(host, user, password):
    print("\nConectando al servidor FTPS seguro...")
    try:
        # Configurar contexto SSL para ignorar verificación de certificado (común en Ferozo con certificados compartidos)
        context = ssl.create_default_context()
        context.check_hostname = False
        context.verify_mode = ssl.CERT_NONE

        ftp = FTP_TLS(context=context)
        ftp.connect(host, 21, timeout=60)
        ftp.login(user, password)
        ftp.prot_p() # Forzar canal de datos seguro
        print("✓ Conexión FTPS segura establecida.")
        return ftp
    except Exception as e:
        print(f"❌ Error al conectar por FTPS seguro: {e}")
        return None

def change_or_create_dir(ftp, remote_path):
    parts = [p for p in remote_path.replace("\\", "/").split("/") if p]
    current = ""
    for part in parts:
        current += f"/{part}"
        try:
            ftp.cwd(current)
        except Exception:
            try:
                ftp.mkd(current)
                ftp.cwd(current)
                print(f"✓ Directorio creado: {current}")
            except Exception as e:
                print(f"❌ No se pudo cambiar ni crear el directorio {current}: {e}")
                return False
    return True

def upload_donweb():
    print("======================================================")
    print("      ASISTENTE DE SUBIDA FTPS SEGURA A DONWEB        ")
    print("======================================================")
    
    unzip_file = "unzip.php"
    deploy_zip = "deploy.zip"

    if not os.path.exists(deploy_zip):
        print(f"❌ Error: No se encontró '{deploy_zip}'. Ejecuta primero 'python3 prepare_deploy.py'.")
        return
    if not os.path.exists(unzip_file):
        print(f"❌ Error: No se encontró '{unzip_file}'. Ejecuta primero 'python3 prepare_deploy.py'.")
        return

    # Valores por defecto configurados para lydam.store
    default_host = "a0150776.ferozo.com"
    default_user = "a0150776"

    host = input(f"Servidor FTP [Enter para {default_host}]: ").strip()
    if not host:
        host = default_host

    user = input(f"Usuario FTP [Enter para {default_user}]: ").strip()
    if not user:
        user = default_user

    password = getpass.getpass("Contraseña FTP: ")

    ftp = connect_ftps(host, user, password)
    if not ftp:
        return

    ftp.set_pasv(True)

    try:
        # Subida a la raíz de public_html
        remote_path = "public_html"
        print(f"\nPreparando carpeta de destino: {remote_path}")
        
        if change_or_create_dir(ftp, remote_path):
            upload_file_ftps(ftp, unzip_file, "unzip.php")
            upload_file_ftps(ftp, deploy_zip, "deploy.zip")
            
            print("\n======================================================")
            print("          ¡SUBIDA FINALIZADA CON ÉXITO!               ")
            print("======================================================")
            print("Siguientes pasos en producción:")
            print("\n1. Abre tu navegador y visita:")
            print("   http://lydam.store/unzip.php")
            print("2. Espera a que en pantalla diga '¡DESPLIEGUE FINALIZADO EXITOSAMENTE!'.")
            print("3. BORRA DE INMEDIATO los archivos 'unzip.php' y 'deploy.zip' del FTP.")
            print("4. Ejecuta las migraciones y seeders de categorías abriendo en tu navegador:")
            print("   https://lydam.store/run_migrations.php")
            print("5. BORRA DE INMEDIATO el archivo 'run_migrations.php' de tu servidor.")
        else:
            print("❌ Cancelando subida debido a un error en el directorio remoto.")

    except Exception as e:
        print(f"\n❌ Error durante la transferencia: {e}")
    finally:
        try:
            ftp.quit()
            print("\nConexión FTPS cerrada.")
        except Exception:
            pass

if __name__ == "__main__":
    upload_donweb()
