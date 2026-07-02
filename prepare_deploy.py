import os
import zipfile
import subprocess
import shutil

def run_npm_build():
    print("Compilando recursos CSS/JS para producción con Vite (npm run build)...")
    try:
        subprocess.run(["npm", "run", "build"], check=True)
        print("✓ Recursos compilados con éxito.")
    except subprocess.CalledProcessError as e:
        print("❌ Error al compilar recursos:", e)
        return False
    return True

def create_zip(zip_filename, exclude_dirs, exclude_files, source_dir="."):
    print(f"Creando archivo de despliegue {zip_filename}...")
    
    count = 0
    with zipfile.ZipFile(zip_filename, 'w', zipfile.ZIP_DEFLATED) as zipf:
        for root, dirs, files in os.walk(source_dir):
            relative_root = os.path.relpath(root, source_dir)
            if relative_root != ".":
                normalized_root = relative_root.replace("\\", "/")
                # Verificar si alguna parte de la ruta está en directorios excluidos
                skip = False
                for ex_dir in exclude_dirs:
                    if normalized_root == ex_dir or normalized_root.startswith(ex_dir + "/"):
                        skip = True
                        break
                if skip:
                    continue
            
            # Filtrar subdirectorios en os.walk
            dirs[:] = [d for d in dirs if os.path.join(relative_root, d).replace("\\", "/") not in exclude_dirs]
            
            for file in files:
                file_path = os.path.join(root, file)
                rel_path = os.path.relpath(file_path, source_dir)
                normalized_rel_path = rel_path.replace("\\", "/")
                
                # Excluir archivos específicos
                if normalized_rel_path in exclude_files or file == ".DS_Store":
                    continue
                
                zipf.write(file_path, rel_path)
                count += 1
                
    print(f"✓ Archivo {zip_filename} creado. Se agregaron {count} archivos.")

def generate_unzip_script():
    script_content = """<?php
// unzip.php - Ayudante de despliegue de LYDAM para DonWeb
header('Content-Type: text/plain; charset=utf-8');

$zipFile = 'deploy.zip';
if (file_exists('deploy_laravel.zip')) {
    $zipFile = 'deploy_laravel.zip';
} elseif (file_exists('deploy_linktree.zip')) {
    $zipFile = 'deploy_linktree.zip';
}

if (!file_exists($zipFile)) {
    die("Error: No se encontró el archivo $zipFile en la raíz.\\n");
}

echo "Iniciando descompresión de $zipFile...\\n";

if (class_exists('ZipArchive')) {
    $zip = new ZipArchive;
    if ($zip->open($zipFile) === TRUE) {
        $zip->extractTo(__DIR__);
        $zip->close();
        echo "¡Descompresión completada con éxito!\\n\\n";
        
        if ($zipFile === 'deploy_laravel.zip') {
            // Crear carpetas de cache de Laravel si no existen
            $dirs = [
                'storage/app/public',
                'storage/framework/cache/data',
                'storage/framework/sessions',
                'storage/framework/views',
                'storage/logs',
                'bootstrap/cache'
            ];
            
            foreach ($dirs as $dir) {
                if (!file_exists(__DIR__ . '/' . $dir)) {
                    mkdir(__DIR__ . '/' . $dir, 0775, true);
                    echo "Directorio creado: $dir\\n";
                }
            }
            
            // Crear base de datos sqlite vacía si no existe
            $dbFile = __DIR__ . '/database/database.sqlite';
            if (!file_exists($dbFile)) {
                if (!file_exists(dirname($dbFile))) {
                    mkdir(dirname($dbFile), 0775, true);
                }
                touch($dbFile);
                chmod($dbFile, 0775);
                echo "Base de datos SQLite creada en: database/database.sqlite\\n";
            }
            
            // Configurar permisos
            echo "Configurando permisos de escritura...\\n";
            @chmod(__DIR__ . '/storage', 0775);
            @chmod(__DIR__ . '/bootstrap/cache', 0775);
        }
        
        echo "\\n======================================================\\n";
        echo "¡DESPLIEGUE FINALIZADO EXITOSAMENTE!\\n";
        echo "======================================================\\n";
        echo "ATENCIÓN: Por motivos de seguridad extrema, elimina de\\n";
        echo "inmediato este archivo (unzip.php) y el zip ($zipFile)\\n";
        echo "de tu servidor.\\n";
    } else {
        echo "Error al abrir el archivo $zipFile.\\n";
    }
} else {
    echo "Error: La clase ZipArchive no está disponible en este servidor de PHP. Solicita al soporte de DonWeb que la active o extrae el archivo $zipFile usando el Administrador de Archivos de Ferozo/cPanel.\\n";
}
"""
    with open("unzip.php", "w", encoding="utf-8") as f:
        f.write(script_content)
    print("✓ Script auxiliar unzip.php generado.")

if __name__ == "__main__":
    if run_npm_build():
        # Exclusiones para la tienda Laravel
        laravel_exclude_dirs = {
            ".git",
            ".github",
            "node_modules",
            "FOTOS",
            "custom_linktree",
            "storage/framework/cache/data",
            "storage/framework/sessions",
            "storage/framework/views",
            "storage/logs",
        }
        
        laravel_exclude_files = {
            ".env",
            "deploy.zip",
            "deploy_laravel.zip",
            "deploy_linktree.zip",
            "prepare_deploy.py",
            "upload_donweb.py",
            "unzip.php",
            ".DS_Store",
        }

        # 1. Crear deploy_laravel.zip
        create_zip("deploy_laravel.zip", laravel_exclude_dirs, laravel_exclude_files)

        # 2. Crear deploy_linktree.zip
        create_zip("deploy_linktree.zip", set(), {".DS_Store"}, "custom_linktree")

        # 3. Generar unzip.php
        generate_unzip_script()
        
        print("\n======================================================")
        print("          ¡EMPAQUETADO COMPLETADO CON ÉXITO!          ")
        print("======================================================")
        print("Archivos generados:")
        print("- 'deploy_laravel.zip' (Tienda completa)")
        print("- 'deploy_linktree.zip' (Linktree estático)")
        print("- 'unzip.php' (Script de extracción para el servidor)")
        print("\nPara subir estos archivos a DonWeb, ejecuta:")
        print("  python3 upload_donweb.py")
