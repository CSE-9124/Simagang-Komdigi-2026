<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Intern;
use App\Services\HolidayService;
use App\Services\TimeService;
use Illuminate\Console\Command;

class MarkAlfaCommand extends Command
{
    protected $signature = 'attendance:mark-alfa';

    protected $description = 'Tandai otomatis alfa (tidak hadir) di akhir hari untuk intern yang belum absen pada hari kerja';

    public function handle(): int
    {
        $nowWita = TimeService::nowWita();
        $todayWita = $nowWita->toDateString();

        $checkInEnd = env('ATTENDANCE_CHECKIN_END', '10:00');
        $currentTime = $nowWita->format('H:i');

        if ($currentTime <= $checkInEnd) {
            $this->info("Belum melewati batas check-in ({$checkInEnd}) — belum ada proses alfa.");
            return self::SUCCESS;
        }

        $this->info('Memproses alfa tanggal ' . $todayWita . ' (WITA) ...');

        // Skip jika hari Sabtu atau Minggu
        if (HolidayService::isWeekend($nowWita)) {
            $dayName = $nowWita->isSaturday() ? 'Sabtu' : 'Minggu';
            $this->info("Hari ini {$dayName} — tidak ada proses alfa.");
            return self::SUCCESS;
        }

        // Skip jika tanggal merah nasional
        if (HolidayService::isNationalHoliday($nowWita)) {
            $holidayName = HolidayService::getHolidayName($nowWita) ?? 'Hari Libur Nasional';
            $this->info("Hari ini libur ({$holidayName}) — tidak ada proses alfa.");
            return self::SUCCESS;
        }

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


