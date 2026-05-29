<?php

use Illuminate\Support\Facades\Schedule;

// Jadwalkan scraping berita setiap 6 jam
Schedule::command('news:scrape')->everySixHours()->withoutOverlapping();

// Alternatif: setiap 6 jam dengan waktu spesifik
// Schedule::command('news:scrape')->cron('0 */6 * * *');

// Untuk testing: setiap menit (hanya untuk development)
// Schedule::command('news:scrape')->everyMinute();