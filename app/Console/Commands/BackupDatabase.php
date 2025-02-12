<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupDatabase extends Command
{
    protected $signature = 'backup:database';
    protected $description = 'Backup the database and save it to storage';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $databaseName = env('boardinghouse');
        $username = env('root');
        $password = env('');
        $host = env('127.0.0.1');
        $backupFile = 'backup-' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';

        $command = "mysqldump --user={$username} --password={$password} --host={$host} {$databaseName} > " . storage_path("app/backups/{$backupFile}");

        $process = shell_exec($command);

        if ($process === null) {
            $this->info("Database backup successfully saved as {$backupFile}");
        } else {
            $this->error("Database backup failed.");
        }
    }
}
