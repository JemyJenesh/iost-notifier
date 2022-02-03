<?php

namespace App\Http\Controllers\api;

use Goutte\Client;
use App\Models\Notice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class NoticeController extends Controller
{
  private $results = array();

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // $client = new Client();
    // $url = 'https://www.tuiost.edu.np/notices';

    // $page = $client->request('GET', $url);

    // $page->filter('.feature-content div.mt-3')->each(function ($item) {
    //   $this->results[] = [
    //     'notice' => $item->filter('a b')->text(),
    //     'date' => $item->filter('small')->text(),
    //     'link' => $item->filter('a')->attr('href')
    //   ];

    //   Notice::updateOrCreate(
    //     ['title' => $item->filter('a b')->text()],
    //     ['date' => $item->filter('small')->text()]
    //   );
    // });

    // echo "<pre>";
    // print_r($this->results);

    $this->scrapNotice();

    return Notice::latest()->paginate(20);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }

  public function scrapNotice()
  {
    $client = new Client();
    $url = 'https://www.tuiost.edu.np/notices';

    $page = $client->request('GET', $url);

    $page->filter('.feature-content div.mt-3')->each(function ($item) {
      $this->results[] = [
        'title' => $item->filter('a b')->text(),
        'link' => $item->filter('a')->attr('href'),
        'date' => $item->filter('small')->text()
      ];
    });

    $reveresed = array_reverse($this->results);

    foreach ($reveresed as $item) {
      Notice::updateOrCreate(
        [
          'title' => $item['title'],
          'link' => $item['link']
        ],
        ['date' => $item['date']]
      );
    }
  }
}
