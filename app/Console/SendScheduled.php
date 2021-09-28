<?php
namespace App\Console;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Schedule;
use App\Message;
use App\Contact;
use App\Group;
use App\User;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;

use Illuminate\Support\Str;
use Amqp;

class SendScheduled
{

  public function __invoke()
  {
    $now = Carbon::now()->format('Y-m-d H:i:59');
    $nowP = Carbon::now()->format('Y-m-d H:i:00');
    $contacts = Schedule::select('id','user_id','contact_id','source','text')->whereNotNull('contact_id')->where('status', 'pending')->where('send_time', '>=', $nowP)->where('send_time', '<=', $now)->get();
    $groups = Schedule::select('id','user_id','group_id','source','text')->whereNotNull('group_id')->where('status', 'pending')->where('send_time', '>=', $nowP)->where('send_time', '<=', $now)->get();
    var_dump($now);
    var_dump(json_encode($contacts));
    var_dump(json_encode($groups));
    if ($contacts) {
      $this->sendContacts($contacts);
    }
    if ($groups) {
      $this->sendGroups($groups);
    }

  }

  private function sendContacts($contacts)
  {
    foreach ($contacts as $key) {
      $dest = Contact::find($key->contact_id);
      $user = User::find($key->user_id);
      $source = $key->source;
      $text = $key->text;
      $sen = $this->sendSMS($dest, $user, $source, $text);
      var_dump($sen);
      if ($sen) {
        Schedule::updateOrCreate(['id' => $key->id],
        ['status' => 'sent']);
      } else {
        Schedule::updateOrCreate(['id' => $key->id],
        ['status' => 'failed']);
      }

    }

  }

  private function sendGroups($groups)
  {

    foreach ($groups as $key) {
      $user = User::find($key->user_id);
      $group = Group::find($key->group_id);
      $source = $key->source;
      $text = $key->text;
      $data = $group->contacts;
      foreach ($data as $dt) {
        // Message::create(
        // ['client_id' => $key->client_id, 'user_id' => $key->user_id, 'source' => $source, 'dest' => $key->phonenumber, 'text' => $text]);
        $sen = $this->sendSMS($dt, $user, $source, $text);
        var_dump($sen);
      }
      if ($sen) {
        Schedule::updateOrCreate(['id' => $key->id],
        ['status' => 'sent']);
      } else {
        Schedule::updateOrCreate(['id' => $key->id],
        ['status' => 'failed']);
      }
    }

  }

  private function sendSMS($dest, $user, $source, $text)
  {
    $phonenumber = $dest->phonenumber;
    $name = $dest->name;
    $field_1 = $dest->field_1;
    $field_2 = $dest->field_2;
    $field_3 = $dest->field_3;
    $requestText = $text;
    $requestText = str_replace("<name>", $name, $requestText);
    $requestText = str_replace("<field_1>", $field_1, $requestText);
    $requestText = str_replace("<field_2>", $field_2, $requestText);
    $requestText = str_replace("<field_3>", $field_3, $requestText);

    $arr = array(
      'user' => $user,
      'send' => array(
        'user' => $user->username,
        'source' => $source,
        'dest' => $dest->phonenumber,
        'message' => $requestText,
        'msgID' => Str::random(12)
      )
    );
    
    $js = json_encode($arr);

    try {
      Amqp::publish('RKey-LARAVEL', $js, [ 'queue' => 'SENDLARAVEL-Q','exchange_type' => 'direct','exchange' => 'SMS-EXCHANGE'] );  
      $fin = true;
      return $fin;
    }
    catch (RequestException $e) {
      if ($e->hasResponse()) {
        $response = $e->getResponse();
        // var_dump($response->getStatusCode())
        // var_dump($response->getReasonPhrase());
        $res = json_decode($response->getBody());
        // return response()->json($res->error);
        // return back()->with('error',$res->error);
        var_dump($res->error);
      }
      $fin = true;
      return $fin;
    }
    catch (ConnectException $e) {
      if ($e) {
        $fin = false;
        return $fin;
      }
    }
  }

}
