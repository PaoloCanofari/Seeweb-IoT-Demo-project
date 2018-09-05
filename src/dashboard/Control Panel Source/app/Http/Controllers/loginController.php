<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use DB;
use Schema;
use Redirect;

class loginController extends BaseController
{
     public function login(Request $req)
     {
      if($req->input("arg") == "logged")
      {
        try {
          return $this->checkDashboard($req->input("currentaccount"));

        } catch (\Exception $e) {

          return view('home', ['email' => $req->input("currentaccount"), 'error' => 'No Dashboard found']);

        }
      }
      else{
        $email = $req->input('email');
        $password = $req->input('password');

        $checkLogin = DB::connection('mysql')->table('users')->where(['email'=>$email,'password'=>$password])->get();

        if(count($checkLogin)  >0)
        {
          //return home view
          try {
            return $this->checkDashboard($email);

          } catch (\Exception $e) {

            return view('home', ['email' => $email, 'error' => 'No Dashboard found']);
          }

        }
        else
        {
          //redirect to login page with errors
          return Redirect("/")->withErrors('Wrong credentials!');
        }
       }
      }

      public function checkDashboard($email){

        //grabs data from database as an object class
        $data = DB::connection('mysql')->table("dashboards")->where(["email" => $email])->get();

        if(count($data) > 0){
          foreach ($data as $key) {
            return $this->getPanels($key->email, $key->dashboard_id, $key->url, $key->token);
          }
        }else{
          return view('home', ['email' => $email, 'error' => 'No Dashboard found']);
          }

      }

      public function getPanels($email, $dashboradID, $url_request, $token){

        // make HTTP POST request to grafana using token API. Every documentation at http://docs.grafana.org/http_api/dashboard/
        $dashboard_curl = $url_request."api/dashboards/uid/".$dashboradID;

        $authorization = "Authorization: Bearer ".$token;

        $request = curl_init($dashboard_curl);

        curl_setopt($request, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));

        curl_setopt($request, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true); //otherwise it returns 1

        $result = curl_exec($request);
        $json_output = json_decode($result,true);

        $meta = $json_output["meta"];
        $url = $meta["url"];

        //changing the /d/ to /d-solo/ is essential for a good rendering in frame
        $url = $url_request.str_replace( "/d/", "d-solo/",$url);

        //echo "Dashboard url: ".$url."<br>";

        $dashboard = $json_output["dashboard"];
        $panels = $dashboard["panels"];

        return view("home", ['panels' => $panels, 'url' => $url, 'email'=>$email, 'dashboardID' => $dashboradID]);
      }

}
?>
