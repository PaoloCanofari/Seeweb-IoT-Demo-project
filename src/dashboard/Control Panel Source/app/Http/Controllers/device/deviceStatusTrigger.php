<?php
namespace App\Http\Controllers\device;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use DB;
use Redirect;

class deviceStatusTrigger extends BaseController
{
     public function updateStatus(Request $req)
     {
       //get the HTTP post body
       $received = file_get_contents("php://input");
       //echo $received;

       //decode json to array
       $json_output = json_decode($received, true);

       //get event type in json
       $event = $json_output["event"];
       $status = $event["type"];

       //get device id
       $device_id = $json_output["device_id"];



         $check_id = DB::connection("mysql")->table("devices")->where(['Device_ID'=>$device_id])->get();
         if(count($check_id) > 0 ){

           //if device ID has been found in Database table

           if($status == "device_connected")
           {
             //update existing row
             $check = DB::connection("mysql")->table("devices")->where(['Device_ID'=>$device_id])->update(['status' => "online"]);
           }
           elseif($status == "device_disconnected"){

             //update existing row
             $check = DB::connection("mysql")->table("devices")->where(['Device_ID'=>$device_id])->update(['status' => "offline"]);
           }

         }
         else{
           echo "DEVICE NOT REGISTERED";
         }

       }
}
?>
