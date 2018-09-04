<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Schema;

//get object array from Database, wich contains current account devices data

$devices = DB::connection("mysql")->table("devices")->where(["email" => $email])->get();

?>
<html>
<head>

  <link rel="stylesheet" type="text/css" href="css/delete.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="css/dropdown_menu.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="css/combo_box.css" media="screen" />

  <style type="text/css">
  /* TABLE */
  .tg  {border-collapse:collapse;border-spacing:0;}
  .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
  .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
  .tg .tg-yw4l{vertical-align:top}

  /* DOTS (red, gree, error)*/
  .dotred {
    height: 10px;
    width: 10px;
    background-color: #FF0000;
    border-radius: 50%;
    display: inline-block;
  }
  .dotgreen {
    height: 10px;
    width: 10px;
    background-color: #00FF00;
    border-radius: 50%;
    display: inline-block;
  }

  </style>

<script>
function status(){
  document.getElementById("arg").value = "status";
  document.getElementById("devices").submit();
}

function register(){
  document.getElementById("arg").value = "register";
  document.getElementById("devices").submit();
}

function dashboard(){
  document.getElementById("devices").action = "login";
  document.getElementById("arg").value = "logged";
  document.getElementById("devices").submit();
}

</script>


</head>

<body>

  <form id='devices' method="POST"  action="devices">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="arg" id="arg" value="">
    <input type ="hidden" name="currentaccount" id="currentaccount" value="{{ $email }}">

    <div class="navbar">

      <a href="javascript: dashboard();">DASHBOARD</a>
      <div class="dropdown">

        <button class="dropbtn" disabled>DEVICES
          <i class="fa fa-caret-down"></i>
        </button>

        <div class="dropdown-content">

          <a href="javascript: status();">Status Table</a>
          <a href="javascript: register();">Register Device</a>

        </div>
      </div>

      <a  href="{{url('/')}}">LOGOUT</a>

    </div>
  </form>

<br><br><br>

<!-- if there are some devices, add them to a table-->

<?php if (count($devices) > 0): ?>
  <table class="tg" align="center">
    <tr>
      <th style="font-weight:bold">Device Name</th>
      <th style="font-weight:bold">Device ID</th>
      <th style="font-weight:bold">Device Status</th>
    </tr>
    @foreach($devices as $key => $data)
    <tr>
      <th>{{$data->DeviceName}}</th>
      <th>{{$data->Device_ID}}</th>
      <th>{{$data->status}} @if($data->status == "offline")
        <span class="dotred"></span>
        @elseif($data->status == "online")
        <span class="dotgreen"></span>
        @endif
       </th>
    </tr>

    @endforeach
  </table>

  <br><br><br>

  <div class="grid">

    <!-- Check if error message has been passed from controller. If yes, print it-->

    @if(isset($msg) && strlen($msg) != 0)
      <h4 color="blue" style="color: green">{{$msg}}</h4>
    @elseif(isset($error) && strlen($error) != 0)
      <h4 class="shake" style="color: red">{{$error}}</h4>
    @endif

  <form action="delete_device" method="POST" class="form login">

    <!-- add the csrf_token inside query, otherwise an error will be returned by controller -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <!-- send to controller the current account email -->
    <input type ="hidden" name="currentaccount" id="currentaccount" value="{{ $email }}">

    <div class="form__field">
      <input id="delete_ID" type="text" name="ID" class="form__input" placeholder="ID" required>
    </div>

    <div class="form__field">
      <input onclick="return confirm('Are you sure to delete this device from your dashboard?');" type="submit" value="Delete device" >
    </div>

<?php else: ?>

  <h4> No devices found, you should register some. </h4>

<?php endif; ?>

  </form>
</div>


  <br>
  <br>
</body>

</html>
