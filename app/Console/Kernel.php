<?php

namespace App\Console;

use Goutte\Client;
use App\Models\Notice;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule)
  {
    // $schedule->command('inspire')->hourly();

    $schedule->call(function () {

      $client = new Client();
      $url = 'https://www.tuiost.edu.np/notices';

      $page = $client->request('GET', $url);

      $page->filter('.feature-content div.mt-3')->each(function ($item) {
        Notice::updateOrCreate(
          [
            'title' => $item->filter('a b')->text(),
            'link' => $item->filter('a')->attr('href')
          ],
          ['date' => $item->filter('small')->text()]
        );
      });
    })->everyMinute();
    // ->everyTenMinutes()
    //   ->between(17, 18);
  }

  /**
   * Register the commands for the application.
   *
   * @return void
   */
  protected function commands()
  {
    $this->load(__DIR__ . '/Commands');

    require base_path('routes/console.php');
  }
}
