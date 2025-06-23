<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        // Aquí es donde añadirás los comandos para los backups de Spatie

        // Esto indica que se intente ejecutar cada día a la 1 PM (13:00 en formato 24 horas).
        // Si el schedule:run se ejecuta más tarde ese día, y la tarea de la 1 PM no se hizo,
        // Laravel la ejecutará en la primera oportunidad.
        $schedule->command('backup:run')->dailyAt('13:00'); // Backup a la 1 PM
        $schedule->command('backup:clean')->dailyAt('14:00'); // Limpieza a las 2 PM
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands'); // Asegúrate de que esta línea esté, incluso si 'Commands' no existe aún

        require base_path('routes/console.php');
    }
}
