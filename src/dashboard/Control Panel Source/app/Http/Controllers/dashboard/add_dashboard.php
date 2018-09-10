<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use DB;
use Schema;

class add_dashboard extends BaseController
{
     public function main(Request $req)
     {

       $email = $req->input("currentaccount");
       //echo $email;
       return view("change_config/get_api", ['email'=> $email]);
    }

    public function get_api(Request $req)
    {
      $email = $req->input("currentaccount");
      $table = DB::raw("`".$email."`"); //format email to be read as a table name

      $url = $req->input("url");
      $token = $req->input("token");
      $dashboard_id = $req->input("id");
      $dashboard_name = $req->input("db_name");

        //if there's already a dashboard active in database don't do anything, else insert its data in Database table
        $checkExisting = DB::connection('mysql')->table('dashboards')->where(['dashboard_id'=>$dashboard_id])->get();

        if(count($checkExisting) > 0)
        {}
        else{
          DB::connection("mysql")->table("dashboards")->insert(['Dashboard_Name' => $dashboard_name, 'email' => $email, 'dashboard_id' => $dashboard_id, 'url' => $url, 'token' => $token]);
        }
        return view("change_config/get_api", ['email'=> $email, "msg" => "Dashboard successfully registered. Remember: you can keep only a dashboard at a time!"]);

    }
}
?>
