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
use Schema;
use Doctrine\DBAL\Driver\PDOMySql\Driver;
class delete_device extends BaseController
{
     public function delete(Request $req)
     {
       //get the HTTP post body
       $ID = $req->input('ID');
       $email = $req->input('currentaccount');

  /*   if (Schema::connection("accounts")->hasTable($email) == true) {
         echo "FOUND";
       } */

       //check if lenght input is == 22

       if(strlen($ID) == 22){
         //check if device is in database
         $check = DB::connection("mysql")->table("devices")->where(['Device_ID'=>$ID])->get();
         if(count($check) > 0){

           DB::connection("mysql")->table("devices")->where(['Device_ID'=>$ID])->delete();
           return view("devices")->with(["email" => $email,"msg" => "Device removed from your table!\nPlease, keep in mind the device has been removed from your data table, but it still present in your Astarte database! If you want, you can register it again."]);
         }
         else{
           return view("devices")->with(["email" => $email,"error" => "Device ID not found"]);
         }
       }
       else{
         //too short
         return view("devices")->with(["email" => $email,"error" => "Device ID invalid: lenght incorrect!"]);
       }

       //else return error and add the h4 tag in view

    }
}
?>
