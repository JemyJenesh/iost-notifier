<?php

namespace App\Observers;

use App\Models\Notice;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NoticeObserver
{
  /**
   * Handle the Notice "created" event.
   *
   * @param  \App\Models\Notice  $notice
   * @return void
   */
  public function created(Notice $notice)
  {
    $response = Http::withToken(
      env('ONESIGNAL_REST_API_KEY')
    )->post('https://onesignal.com/api/v1/notifications', [
      'app_id' => env('ONESIGNAL_APP_ID', 'default_value'),
      'included_segments' => ["Subscribed Users"],
      'data' => ['foo' => 'bar'],
      "contents" => ["en" => $notice->title]
    ]);


    Log::info($response);
  }

  /**
   * Handle the Notice "updated" event.
   *
   * @param  \App\Models\Notice  $notice
   * @return void
   */
  public function updated(Notice $notice)
  {
    //
  }

  /**
   * Handle the Notice "deleted" event.
   *
   * @param  \App\Models\Notice  $notice
   * @return void
   */
  public function deleted(Notice $notice)
  {
    //
  }

  /**
   * Handle the Notice "restored" event.
   *
   * @param  \App\Models\Notice  $notice
   * @return void
   */
  public function restored(Notice $notice)
  {
    //
  }

  /**
   * Handle the Notice "force deleted" event.
   *
   * @param  \App\Models\Notice  $notice
   * @return void
   */
  public function forceDeleted(Notice $notice)
  {
    //
  }
}
