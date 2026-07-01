import os
import sys
from ftplib import FTP, FTP_TLS
import getpass

def upload_to_donweb():
    zip_file = "deploy.zip"
    php_file = "unzip.php"
    
    if not os.path.exists(zip_file) or not os.path.exists(php_file):
        print("❌ Error: No se encontró 'deploy.zip' o 'unzip.php'. Ejecuta primero 'python3 prepare_deploy.py'.")
        return

    print("======================================================")
    print("      ASISTENTE DE SUBIDA AUTOMÁTICA A DONWEB         ")
    print("======================================================")
    print("Introduce tus credenciales de FTP de DonWeb.")
    print("(No quedarán guardadas en ningún archivo por seguridad)\n")

    host = input("Servidor FTP (ej: ftp.tudominio.com o la IP de DonWeb): ").strip()
    user = input("Usuario FTP: ").strip()
    password = getpass.getpass("Contraseña FTP: ")
    
    remote_path = input("Carpeta remota (Presiona Enter para la raíz '/', o escribe 'public_html'): ").strip()
    if not remote_path:
        remote_path = "/"

    print("\nConectando al servidor FTP...")
    
    # Intentar conexión segura FTPS primero (SSL/TLS implicit/explicit)
    ftp = None
    try:
        print("Intentando conexión segura FTPS...")
        ftp = FTP_TLS()
        ftp.connect(host, 21, timeout=30)
        ftp.login(user, password)
        ftp.prot_p() # Cambiar a canal de datos seguro
        print("✓ Conexión segura FTPS establecida.")
    except Exception as e:
        print(f"⚠️ Conexión segura no disponible o fallida ({e}).")
        print("Intentando conexión FTP estándar (sin cifrado)...")
        try:
            ftp = FTP()
            ftp.connect(host, 21, timeout=30)
            ftp.login(user, password)
            print("✓ Conexión FTP estándar establecida.")
        except Exception as e2:
            print(f"❌ Error de conexión FTP: {e2}")
            return

    try:
        ftp.set_pasv(True) # Activar modo pasivo
        
        # Moverse a la carpeta destino
        if remote_path != "/":
            try:
                ftp.cwd(remote_path)
                print(f"✓ Cambiado al directorio remoto: {remote_path}")
            except Exception:
                # Intentar crear la carpeta si no existe
                try:
                    ftp.mkd(remote_path)
                    ftp.cwd(remote_path)
                    print(f"✓ Creado y cambiado al directorio remoto: {remote_path}")
                except Exception as e:
                    print(f"❌ No se pudo acceder o crear la carpeta '{remote_path}': {e}")
                    return

        # Subir unzip.php
        print(f"\nSubiendo {php_file}...")
        with open(php_file, "rb") as f:
            ftp.storbinary(f"STOR {php_file}", f)
        print(f"✓ {php_file} subido con éxito.")

        # Subir deploy.zip con barra de progreso simple
        file_size = os.path.getsize(zip_file)
        print(f"\nSubiendo {zip_file} ({file_size / (1024*1024):.2f} MB)...")
        print("Esto puede tardar unos minutos dependiendo de tu conexión. Por favor, espera.")
        
        uploaded = 0
        def progress_callback(block):
            nonlocal uploaded
            uploaded += len(block)
            percent = (uploaded / file_size) * 100
            sys.stdout.write(f"\rProgreso: {percent:.1f}% ({uploaded / (1024*1024):.2f} MB / {file_size / (1024*1024):.2f} MB)")
            sys.stdout.flush()

        with open(zip_file, "rb") as f:
            ftp.storbinary(f"STOR {zip_file}", f, callback=progress_callback)
            
        print("\n✓ deploy.zip subido con éxito.")
        
        print("\n======================================================")
        print("          ¡SUBIDA FINALIZADA CON ÉXITO!               ")
        print("======================================================")
        print("Pasos finales:")
        print("1. Entra a tu navegador web a la dirección:")
        print(f"   http://{host.replace('ftp.', '')}/unzip.php")
        print("   (Si tu dominio ya está activo, usa http://tudominio.com/unzip.php)")
        print("2. Espera a que el navegador muestre '¡DESPLIEGUE FINALIZADO EXITOSAMENTE!'.")
        print("3. Entra a tu panel Ferozo/cPanel de DonWeb, ve al Administrador de Archivos,")
        print("   crea el archivo .env de producción, configura los accesos y borra unzip.php y deploy.zip.")

    except Exception as e:
        print(f"\n❌ Error durante la transferencia de archivos: {e}")
    finally:
        try:
            ftp.quit()
            print("\nConexión FTP cerrada.")
        except Exception:
            pass

if __name__ == "__main__":
    upload_to_donweb()
