<?php
namespace App\Http\Controllers\device;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Mail;
use DB;
use Redirect;

class overValueTrigger extends BaseController
{
  public function main(Request $req)
  { /*
    //get the HTTP post body
    $received = file_get_contents("php://input");

    //decode json to array
    $json_output = json_decode($received, true);

    //get event type in json object
    $event = $json_output["event"];
    $path = $event["path"];

    $deviceID = $json_output["device_id"];

    $check_existingTrigger = DB::connection("mysql")->table("DataTriggers")->where(['Device_ID' => $deviceID, 'Data_Path' => $path])->get();
    if(count($check_existingTrigger) > 0)
    {
      if($check_existingTrigger[0]->status == "enabled"){
      }
      else
      {
        //update existing row
        DB::connection("mysql")->table("DataTriggers")->where(['Device_ID' => $deviceID, 'Data_Path' => $path])->update(['status' => 'enabled']);
        $device_data = DB::connection("mysql")->table("devices")->where(['Device_ID' => $deviceID])->get();

        foreach ($device_data as $key => $data) {
          $this->sendMail($data);
        }

      }
    }
    else{
      //create new row
      DB::connection("mysql")->table("DataTriggers")->insert(['Device_ID' => $deviceID, 'Data_Path' => $path, 'status' => 'enabled']);

      $device_data = DB::connection("mysql")->table("devices")->where(['Device_ID' => $deviceID])->get();

      foreach ($device_data as $key => $data) {
        $this->sendMail($data);
      }
    } */
    // get the POST body with php://input
    $received = file_get_contents("php://input");

    // encode to json
    $json_output = json_decode($received, true);

    // save json data to a file
    $file_handle = fopen('over_temp.json', 'w');
    fwrite($file_handle, $received);
    fclose($file_handle);
  }

  public function sendMail($data){
    $text = 'Buongiorno da '.$data->DeviceName."!";
    $email = $data->email;
    try {
      Mail::raw($text, function ($message) use ($email) {
          $message->to($email)->subject("Trigger activation");
          $message->from('SeewebIoT@seeweb.it', 'SeewebIoT Service');
      });
    } catch (\Exception $e) {
      echo $e;
    }
    echo "sent";
  }
}
