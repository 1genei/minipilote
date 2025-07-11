<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CleanTempFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:temp-files {--hours=24 : Nombre d\'heures avant suppression}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Nettoie les fichiers temporaires de prévisualisation des factures';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hours = $this->option('hours');
        $cutoffTime = Carbon::now()->subHours($hours);
        
        $this->info("Nettoyage des fichiers temporaires plus anciens que {$hours} heures...");
        
        $tempPath = 'temp/factures';
        $deletedCount = 0;
        
        if (Storage::disk('public')->exists($tempPath)) {
            $files = Storage::disk('public')->files($tempPath);
            
            foreach ($files as $file) {
                $lastModified = Carbon::createFromTimestamp(Storage::disk('public')->lastModified($file));
                
                if ($lastModified->lt($cutoffTime)) {
                    Storage::disk('public')->delete($file);
                    $deletedCount++;
                    $this->line("Supprimé : {$file}");
                }
            }
        }
        
        $this->info("Nettoyage terminé. {$deletedCount} fichiers supprimés.");
        
        return 0;
    }
} 