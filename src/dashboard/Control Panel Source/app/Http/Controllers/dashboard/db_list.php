<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use DB;

class db_list extends BaseController
{
    public function main(Request $req){
      $email = $req->input("currentaccount");

      $dashboards = DB::connection("mysql")->table("dashboards")->where(["email" => $email])->get();
      if(count($dashboards) > 0){

        return view("db_list", ["email" => $email, "dashboards" => $dashboards]);

      }else{
          return view("db_list", ["email" => $email, "error" => "No Dashboard founds!"]);
      }
    }
}
