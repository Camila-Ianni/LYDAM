<?php
// run_migrations.php - Herramienta temporal para correr las migraciones de base de datos en DonWeb

header('Content-Type: text/plain; charset=utf-8');

// Boot Laravel
require __DIR__.'/../bootstrap/app.php';

use Illuminate\Support\Facades\Artisan;

echo "Iniciando ejecución de migraciones en producción...\n";

try {
    $exitCode = Artisan::call('migrate', [
        '--force' => true,
    ]);
    
    echo "✓ Migraciones completadas con éxito.\n";
    echo "Código de salida: " . $exitCode . "\n\n";
    echo "Detalle del log:\n";
    echo Artisan::output();
    
    // También correremos el CategorySeeder automáticamente para asegurar que estén cargadas las categorías
    echo "\nEjecutando CategorySeeder...\n";
    $seederExitCode = Artisan::call('db:seed', [
        '--class' => 'Database\\Seeders\\CategorySeeder',
        '--force' => true,
    ]);
    echo "✓ Seeder completado con éxito.\n";
    echo "Código de salida: " . $seederExitCode . "\n\n";
    echo Artisan::output();

    echo "\n======================================================\n";
    echo "¡MIGRACIONES Y CATEGORÍAS ACTUALIZADAS CON ÉXITO!\n";
    echo "======================================================\n";
    echo "ATENCIÓN: Por motivos de seguridad extrema, elimina de\n";
    echo "inmediato este archivo (run_migrations.php) de tu servidor.\n";
} catch (\Exception $e) {
    echo "❌ Error al ejecutar las migraciones:\n";
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
