<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use DB;

class UpdateDashboard extends BaseController
{
    public function main(Request $req){

      $email = $req->input('currentaccount');
      $dashboardID = $req->input('dashboardSelector');

      $data = DB::connection('mysql')->table("dashboards")->where(["dashboard_id" => $dashboardID])->get();

      if(count($data) > 0){
        foreach ($data as $key) {
        //  return $this->getPanels($key->email, $key->dashboard_id, $key->url, $key->token);

        $dashboard_curl = $key->url."api/dashboards/uid/".$dashboardID;

        $authorization = "Authorization: Bearer ".$key->token;

        $request = curl_init($dashboard_curl);

        curl_setopt($request, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));

        curl_setopt($request, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true); //otherwise it returns 1

        $result = curl_exec($request);
        $json_output = json_decode($result,true);

        $meta = $json_output["meta"];
        $url = $meta["url"];

        //changing the /d/ to /d-solo/ is essential for a good rendering in frame
        $url = $key->url.str_replace( "/d/", "d-solo/",$url);

        //echo "Dashboard url: ".$url."<br>";

        $dashboard = $json_output["dashboard"];
        $panels = $dashboard["panels"];

        return view("home", ['panels' => $panels, 'url' => $url, 'email'=>$email, 'dashboardID' => $dashboardID]);

        }
      }

    }
}
