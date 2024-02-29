<?php

namespace App\Console;

use App\Models\followers;
use App\Models\Statut;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $statut = Statut::select("statuts.uuid", "statuts.id", "statuts.created_at")
                ->where('statuts.created_at', '<=', now()->subHours(24)->toDateTimeString())
                ->get()
                ->toArray();

            if (count($statut) > 0) {
                foreach ($statut as $key => $stat) {
                    $verif = Statut::where("id", intval($stat["id"]))->first();
                    if($verif !== null)
                    {
                        $file = null;
                        if($verif->image !== null)
                        {
                            $file = $verif->image;
                        }
                        else if($verif->video !== null)
                        {
                            $file = $verif->video;
                        }

                        if($file !== null)
                        {
                            unlink(base_path() . "/storage/app/public/statut/" . $file);
                        }
                        $verif->delete();
                    }
                }
            }
        })->cron('*/10 * * * *');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
