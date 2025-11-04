<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Intern;
use App\Services\TimeService;
use Illuminate\Console\Command;

class MarkAlfaCommand extends Command
{
    protected $signature = 'attendance:mark-alfa';

    protected $description = 'Tandai otomatis alfa (tidak hadir) setelah batas check-in untuk intern yang belum absen';

    public function handle(): int
    {
        $nowWita = TimeService::nowWita();
        $todayWita = $nowWita->toDateString();

        $this->info('Memproses alfa tanggal ' . $todayWita . ' (WITA) ...');

        $interns = Intern::query()
            ->where('is_active', true)
            ->whereDate('start_date', '<=', $todayWita)
            ->whereDate('end_date', '>=', $todayWita)
            ->get(['id']);

        $count = 0;
        foreach ($interns as $intern) {
            $exists = Attendance::where('intern_id', $intern->id)
                ->whereDate('date', $todayWita)
                ->exists();
            if (!$exists) {
                Attendance::create([
                    'intern_id' => $intern->id,
                    'date' => $todayWita,
                    'status' => 'alfa',
                ]);
                $count++;
            }
        }

        $this->info("Total ditandai alfa: {$count}");
        return self::SUCCESS;
    }
}


