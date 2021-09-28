<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Log;
use GuzzleHttp\Client as Cl;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use Auth;
use App\Contact;
use App\ContactGroup;
use App\Group;
use Illuminate\Support\Facades\Redis;


class SendMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $row;
    public $request;
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($row,$request,$user)
    {
      $this->row = $row;
      $this->request = $request;
      $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

      Redis::throttle('any_key')->allow(500)->every(1)->then(function ()
        {

          $phonenumber = $this->row['phonenumber'];
          $name = $this->row['name'];
          $field_1 = $this->row['field_1'];
          $field_2 = $this->row['field_2'];
          $field_3 = $this->row['field_3'];
          $requestText = $this->request['text'];
          $requestText = str_replace("<name>", $name, $requestText);
          $requestText = str_replace("<field_1>", $field_1, $requestText);
          $requestText = str_replace("<field_2>", $field_2, $requestText);
          $requestText = str_replace("<field_3>", $field_3, $requestText);

          $requestContent = [
              'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.config('app.go-tok')
              ],
              'json' => [
                'user' => $this->user['username'],
                'source' => $this->request['source'],
                'dest' => $phonenumber,
                'message' => $requestText
              ]
          ];
          try {
            $client = new Cl();
            $apiRequest = $client->request('POST', config('app.go-endpont'), $requestContent);
var_dump(config('app.go-endpont'));
          }
          catch (RequestException $e) {
            if ($e->hasResponse()) {
              $response = $e->getResponse();
              var_dump($response->getStatusCode());
              var_dump($response->getReasonPhrase());
              $res = json_decode($response->getBody());
              // var_dump($response->getBody());
              // return response()->json($res->error);
              // return back()->with('error',$res->error)->with('success', 'For Prefix error: Message is delivered for contacts in the group list occuring before the contact with unavailable route');
            }
          }
          catch (ConnectException $e) {
            if ($e) {
              return response()->json('Failed to connect to routing engine!');
            }
          }


        }, function () {
          return $this->release(500);
        }
      );

    }
}
