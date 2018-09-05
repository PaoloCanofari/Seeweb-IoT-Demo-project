<?php
namespace App\Http\Controllers\device;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use DB;
use Schema;
use Blueprint;

class regDeviceController extends BaseController
{
    public function main(Request $req)
    {
      $email = $req->input("currentaccount");
      $ID = $req->input("ID");
      $name = $req->input("device_Name");

      try {

        if(strlen($ID) == 22)
        {

          $checkExisting = DB::connection('mysql')->table("devices")->where(['Device_ID'=>$ID])->get();

          // if Device doesn't exists in table
          if(count($checkExisting) <= 0)
          {
            DB::connection("mysql")->table("devices")->insert(['email' => $email,'Device_ID' => $ID, 'DeviceName' => $name ,'status' => "offline"]);
            return view('deviceReg', ['email' => $email, 'msg' => 'Device successfully added!']);
          }
          else
          {
            return view('deviceReg', ['email' => $email, 'error' => "Device already exists!"]);
          }

        }
        else{
          return view('deviceReg', ['email' => $email, 'error' => "Device lenght incorrect!"]);
        }


      } catch (\Exception $e) {

        return view('deviceReg', ['email' => $email, 'error' => "System error! Please contact the assistance!"]);

      }


    }

}

?>
