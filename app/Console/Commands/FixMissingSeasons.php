<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Series;
use App\Models\Season;

class FixMissingSeasons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-missing-seasons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crée des saisons pour toutes les séries qui n\'en ont pas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Début de la correction des saisons manquantes...');
        
        // Récupérer toutes les séries
        $series = Series::with('seasons')->get();
        $fixed = 0;
        $alreadyOk = 0;
        
        foreach ($series as $serie) {
            $currentSeasonCount = $serie->seasons()->count();
            $desiredSeasonCount = $serie->seasons ?? 1;
            
            // Si la série n'a pas de saisons ou moins que prévu
            if ($currentSeasonCount < $desiredSeasonCount) {
                $this->line("Correction de la série ID #{$serie->id}: {$currentSeasonCount} saisons sur {$desiredSeasonCount} attendues");
                
                // Ajouter les saisons manquantes
                for ($i = $currentSeasonCount + 1; $i <= $desiredSeasonCount; $i++) {
                    Season::create([
                        'series_id' => $serie->id,
                        'season_number' => $i,
                        'title' => 'Saison ' . $i,
                        'release_date' => now(),
                    ]);
                }
                
                $fixed++;
            } else {
                $alreadyOk++;
            }
        }
        
        $this->info("Terminé ! {$fixed} séries corrigées, {$alreadyOk} séries déjà correctes.");
    }
} 