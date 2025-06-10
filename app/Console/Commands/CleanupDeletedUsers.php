<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class CleanupDeletedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:cleanup-deleted {--days=30 : Number of days to keep soft deleted users}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanently delete users that have been soft deleted for more than specified days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);
          $this->info("Looking for users deleted more than {$days} days ago...");
        
        // Buscar usuarios soft-deleted hace más de X días
        $usersToDelete = User::onlyTrashed()
            ->where('usertype', '!=', 'admin') // Never permanently delete admins
            ->where('deleted_at', '<', $cutoffDate)
            ->get();
        
        if ($usersToDelete->isEmpty()) {
            $this->info('No users found for permanent deletion.');
            return;
        }
        
        $this->info("Found {$usersToDelete->count()} users for permanent deletion:");
        
        foreach ($usersToDelete as $user) {
            $this->line("- {$user->name} ({$user->email}) - Deleted on: {$user->deleted_at->format('d/m/Y H:i')}");
        }
        
        if ($this->confirm('Do you want to proceed with permanent deletion?')) {
            $deletedCount = 0;
              foreach ($usersToDelete as $user) {
                try {
                    $user->forceDelete(); // Eliminación permanente
                    $deletedCount++;
                    $this->line("✓ {$user->name} permanently deleted");
                } catch (\Exception $e) {
                    $this->error("✗ Error deleting {$user->name}: " . $e->getMessage());
                }
            }
            
            $this->info("\n✅ {$deletedCount} users permanently deleted.");
        } else {
            $this->info('Operation cancelled.');
        }
    }
}
