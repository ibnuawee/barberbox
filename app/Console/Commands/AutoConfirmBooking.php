<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoConfirmBooking extends Command
{
    protected $signature = 'booking:autoconfirm';
    protected $description = 'Automatically confirm bookings that are completed but not confirmed by users within 1 day';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $bookings = Booking::where('status', 'completed')
            ->whereNull('confirmed_at')
            ->where('updated_at', '<=', Carbon::now()->subDay())
            ->get();

        foreach ($bookings as $booking) {
            $booking->confirmed_at = now();
            $booking->save();

            $barber = $booking->barber->user;
            $barber->balance += $booking->total_price;
            $barber->save();
        }

        return Command::SUCCESS;
    }
}
