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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Contact;
use App\ContactGroup;
use App\Group;
use App\CsvData;

class UploadContactsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $request;
    public $user;
    public $row;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request,$row,$user)
    {
        $this->request = $request;
        $this->user = $user;
        $this->row = $row;
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

          $phonenumber = "";
          if (!empty($this->row[0])) {
          $phonenumber = $this->row[0];
          $phonenumber = str_replace("+", "", $phonenumber);
          $phonenumber = str_replace(" ", "", $phonenumber);
          }
          $name = "";
          if (!empty($this->row[1])) {
            $name = $this->row[1];
          }
          $field_1 = "";
          if (!empty($this->row[2])) {
            $field_1 = $this->row[2];
          }
          $field_2 = "";
          if (!empty($this->row[3])) {
            $field_2 = $this->row[3];
          }
          $field_3 = "";
          if (!empty($this->row[4])) {
            $field_3 = $this->row[4];
          }


          $arr = array(
            'phonenumber' => $phonenumber,
            'client_id' => $this->user->client_id,
            'user_id' => $this->user->id,
            'name' => $name,
            'field_1' => $field_1,
            'field_2' => $field_2,
            'field_3' => $field_3,
            'group_id' => intval($this->request['group_id'])
          );

          $js = json_encode($arr);
          try {
              Amqp::publish('RKey-ContUpload', $js, [ 'queue' => 'CONTACTSUPLD-Q','exchange_type' => 'direct','exchange' => 'SMS-EXCHANGE'] );
          } catch (RequestException $e) {
              if ($e->hasResponse()) {
                  $response = $e->getResponse();
                  var_dump($response->getStatusCode());
                  var_dump($response->getReasonPhrase());
                  $res = json_decode($response->getBody());
                  var_dump($response->getBody());
                  return response()->json($res->error);
              }
          }
          catch (ConnectException $e) {
              if ($e) {
                  return response()->json('Failed to connect to rabbitMq!');
              }
          }

          // $con = Contact::updateOrCreate(['phonenumber' => $phonenumber, 'client_id' => $this->user->client_id ],
          // ['user_id' => $this->user->id, 'name' => $name, 'field_1' => $field_1, 'field_2' => $field_2, 'field_3' => $field_3]);
          // $gid = intval($this->request['group_id']);
          // if ($gid) {
          //   if (!(ContactGroup::where('contact_id',$con->id)->where('group_id',$this->request['group_id'])->first())) {
          //     $group = Group::find($gid);
          //     var_dump($con->id);
          //     var_dump($group->id);
          //     $group->contacts()->attach($con->id);
          //   }
          // }

        }, function () {
          return $this->release(500);
        }
      );



      // $requestContent = [
      //     'headers' => [
      //         'Accept' => 'application/json',
      //         'Content-Type' => 'application/json'
      //     ],
      //     'json' => [
      //       'filepath' => $this->request['path'],
      //       'groupid' => $this->request['group_id'],
      //       'client_id' => $this->user['client_id'],
      //       'user_id' => $this->user['id']
      //     ]
      // ];
      // try {
      //   $client = new Cl();
      //
      //   $apiRequest = $client->request('POST', config('app.go-contact'), $requestContent);
      // }
      // catch (RequestException $e) {
      //   if ($e->hasResponse()) {
      //     $response = $e->getResponse();
      //     // var_dump($response->getStatusCode())
      //     // var_dump($response->getReasonPhrase());
      //     $res = json_decode($response->getBody());
      //     // return response()->json($res->error);
      //     return back()->with('error',$res->error);
      //   }
      // }
      // catch (ConnectException $e) {
      //   if ($e) {
      //     return response()->json('Failed to connect to go engine!');
      //   }
      // }

      Log::info('Saved contacts:' . $this->user['username']);

    }
}
