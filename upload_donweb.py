import os
import sys
from ftplib import FTP, FTP_TLS
import getpass

def upload_file_ftp(ftp, local_file, remote_file):
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

def connect_ftp(host, user, password):
    print("\nConectando al servidor FTP...")
    # Intentar FTPS primero
    try:
        print("Intentando conexión segura FTPS...")
        ftp = FTP_TLS()
        ftp.connect(host, 21, timeout=30)
        ftp.login(user, password)
        ftp.prot_p()
        print("✓ Conexión segura FTPS establecida.")
        return ftp
    except Exception as e:
        print(f"⚠️ Conexión segura no disponible o fallida ({e}).")
        print("Intentando conexión FTP estándar (sin cifrado)...")
        try:
            ftp = FTP()
            ftp.connect(host, 21, timeout=30)
            ftp.login(user, password)
            print("✓ Conexión FTP estándar establecida.")
            return ftp
        except Exception as e2:
            print(f"❌ Error de conexión FTP: {e2}")
            return None

def change_or_create_dir(ftp, remote_path):
    # remote_path can be nested like "public_html/lydamworld"
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
    print("      ASISTENTE DE SUBIDA AUTOMÁTICA A DONWEB         ")
    print("======================================================")
    print("Selecciona qué deseas subir:")
    print("1. Tienda Laravel (para lydamworld.com.ar)")
    print("2. Linktree personalizado (para lydam.store)")
    print("3. Ambos proyectos (Laravel y Linktree)")
    
    choice = input("\nIntroduce tu opción (1, 2 o 3): ").strip()
    if choice not in ["1", "2", "3"]:
        print("❌ Opción no válida. Cancelando.")
        return

    # Check file availability
    unzip_file = "unzip.php"
    laravel_zip = "deploy_laravel.zip"
    linktree_zip = "deploy_linktree.zip"

    if choice in ["1", "3"] and not os.path.exists(laravel_zip):
        print(f"❌ Error: No se encontró '{laravel_zip}'. Ejecuta primero 'python3 prepare_deploy.py'.")
        return
    if choice in ["2", "3"] and not os.path.exists(linktree_zip):
        print(f"❌ Error: No se encontró '{linktree_zip}'. Ejecuta primero 'python3 prepare_deploy.py'.")
        return
    if not os.path.exists(unzip_file):
        print(f"❌ Error: No se encontró '{unzip_file}'. Ejecuta primero 'python3 prepare_deploy.py'.")
        return

    # Ask credentials
    host = input("\nServidor FTP (ej: ftp.lydam.store o la IP de DonWeb): ").strip()
    user = input("Usuario FTP: ").strip()
    password = getpass.getpass("Contraseña FTP: ")

    ftp = connect_ftp(host, user, password)
    if not ftp:
        return

    ftp.set_pasv(True)

    try:
        if choice in ["1", "3"]:
            # Upload Laravel
            laravel_path = input("\nCarpeta remota para Tienda Laravel (Presiona Enter para 'public_html/lydamworld'): ").strip()
            if not laravel_path:
                laravel_path = "public_html/lydamworld"
            
            print(f"\nPreparando carpeta de destino: {laravel_path}")
            if change_or_create_dir(ftp, laravel_path):
                upload_file_ftp(ftp, unzip_file, "unzip.php")
                upload_file_ftp(ftp, laravel_zip, "deploy_laravel.zip")
                print("✓ Archivos de la tienda Laravel subidos.")
            else:
                print("❌ Cancelando subida de Tienda Laravel debido a un error en el directorio.")

        if choice in ["2", "3"]:
            # Upload Linktree
            linktree_path = input("\nCarpeta remota para Linktree (Presiona Enter para la raíz 'public_html'): ").strip()
            if not linktree_path:
                linktree_path = "public_html"
            
            print(f"\nPreparando carpeta de destino: {linktree_path}")
            if change_or_create_dir(ftp, linktree_path):
                upload_file_ftp(ftp, unzip_file, "unzip.php")
                upload_file_ftp(ftp, linktree_zip, "deploy_linktree.zip")
                print("✓ Archivos del Linktree subidos.")
            else:
                print("❌ Cancelando subida del Linktree debido a un error en el directorio.")

        print("\n======================================================")
        print("          ¡SUBIDA FINALIZADA CON ÉXITO!               ")
        print("======================================================")
        print("Siguientes pasos en producción:")
        
        if choice in ["1", "3"]:
            print("\nPARA LA TIENDA LARAVEL:")
            print("1. Abre tu navegador y visita:")
            print("   http://lydamworld.com.ar/unzip.php")
            print("2. Espera a que diga '¡DESPLIEGUE FINALIZADO EXITOSAMENTE!'.")
            print("3. Crea tu archivo '.env' en esa carpeta, configurá la DB y la Key de Gemini.")
            print("4. Ejecuta las migraciones y seeders abriendo en tu navegador:")
            print("   https://lydamworld.com.ar/run_migrations.php")
            print("5. BORRA DE INMEDIATO los archivos 'unzip.php', 'deploy_laravel.zip' y 'run_migrations.php'.")

        if choice in ["2", "3"]:
            print("\nPARA EL LINKTREE:")
            print("1. Abre tu navegador y visita:")
            print("   http://lydam.store/unzip.php")
            print("2. Espera a que diga '¡DESPLIEGUE FINALIZADO EXITOSAMENTE!'.")
            print("3. BORRA DE INMEDIATO los archivos 'unzip.php' y 'deploy_linktree.zip'.")

    except Exception as e:
        print(f"\n❌ Error durante la transferencia: {e}")
    finally:
        try:
            ftp.quit()
            print("\nConexión FTP cerrada.")
        except Exception:
            pass

if __name__ == "__main__":
    upload_donweb()
