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

class devicesController extends BaseController
{
     public function main(Request $req)
     {
       //get the HTTP post body
       $received = $req->input('arg');
       $email = $req->input('currentaccount');

       // if switch views, depending of the input message
       if($received == "status"){
         return view('devices')->with(['email' => $email]);
       }
      elseif ($received == "register") {
        return view('deviceReg')->with(['email' => $email]);
      }

    }
}
?>
