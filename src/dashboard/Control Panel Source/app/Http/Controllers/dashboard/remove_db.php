<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use DB;

class remove_db extends BaseController
{
    public function main(Request $req){
    	$email = $req->input("currentaccount");
      $dashboard_id = $req->input("dashboard_id");

      $data = DB::connection("mysql")->table("dashboards")->where(["dashboard_id" => $dashboard_id]);

      if(count($data->get()) > 0 ){
          $data->delete();
          $dashboards = DB::connection("mysql")->table("dashboards")->where(["email" => $email])->get();

          return view("db_list", ["email" => $email, "dashboards" => $dashboards]);
      }else{
        $dashboards = DB::connection("mysql")->table("dashboards")->where(["email" => $email])->get();
        return view("db_list", ["email" => $email, "error" => "Dashboard ID not found", "dashboards" => $dashboards]);
      }

    }
}
