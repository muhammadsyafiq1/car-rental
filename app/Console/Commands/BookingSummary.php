<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class BookingSummary extends Command
{

    protected $signature = 'booking:summary';

    protected $description = 'Generate daily summary of bookings';

    public function handle()
    {
        $this->info('Booking Summary - ' . now()->format('Y-m-d'));

        $totalBookings = Booking::count();
        $byStatus = Booking::selectRaw('status, COUNT(*) as count')->groupBy('status')->pluck('count', 'status');
        $totalRevenue = Booking::where('status', 'completed')->sum('total_price');

        // BookingSummary::create([
        //     'tanggal' => now()->toDateString(),
        //     'total' => $totalBookings,
        //     'pending' => $byStatus['pending'] ?? 0,
        //     'confirmed' => $byStatus['confirmed'] ?? 0,
        //     'completed' => $byStatus['completed'] ?? 0,
        //     'canceled' => $byStatus['canceled'] ?? 0,
        //     'revenue' => $totalRevenue,
        // ]);

        // $this->info('Booking summary saved!');

        $this->line("Total bookings       : $totalBookings");
        $this->line("Bookings by status:");
        foreach ($byStatus as $status => $count) {
            $this->line(" - $status: $count");
        }

        $this->line("Total revenue (completed): $totalRevenue");

        return 0;
    }
}
