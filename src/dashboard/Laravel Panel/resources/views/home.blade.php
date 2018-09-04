<?php
  namespace App\Http\Controllers;
  use DB;
?>

<html>
<head>

  <!-- adjust the page to screen widht, to make it visible on smartphones -->
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" type="text/css" href="css/combo_box.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/dropdown_menu.css" media="screen" />

<style>

iframe {
  width: 800px;
  height: 350px;
  margin: 2;
}

</style>

<script>

function create_frames(){

  @if(!isset($error))
  <?php
    foreach($panels as $panel):
  ?>
  var f1 = document.createElement('iframe');
  f1.id = "frame<?php print($panel['id']);?>";
  f1.src = '<?php print($url."?"."orgId=1&from=now-1h&to=now&panelId=".$panel["id"]."&refresh=5s"); ?>';
  f1.frameBorder = 0;
  document.body.appendChild(f1);

  <?php endforeach; ?>
  @endif
}

function framesTimeUpdate() {
  @if(!isset($error))
  var e = document.getElementsByName('TimeRange')[0];
  var value = e.options[e.selectedIndex].value;
  var text = e.options[e.selectedIndex].text;
  document.getElementById("currentRange").innerHTML = "Current Time Range: " + text;
  if(value != "")
  {
    <?php
      foreach($panels as $p):
    ?>
      document.getElementById("frame<?php print($p['id']);?>").src = '<?php print($url."?"."orgId=1&from="); ?>' + value + '<?php print("&to=now&panelId=".$p["id"]."&refresh=5s"); ?>';

    <?php endforeach; ?>
  }
  @endif;
}

function status(){
  document.getElementById("arg").value = "status";
  document.getElementById("devices").submit();
}

function register(){
  document.getElementById("arg").value = "register";
  document.getElementById("devices").submit();
}

function update_config(){
  document.getElementById("devices").action = "change_config";
  document.getElementById("arg").value = "change_config";
  document.getElementById("devices").submit();
}

function getDashboardsIDs(){
  <?php
    $data = DB::connection('mysql')->table("dashboards")->where(["email" => $email])->get();

    if(count($data) > 0){
      foreach ($data as $key) {
        ?>
        try {
          var text = "<?php echo $key->dashboard_id;?>";
          var option = document.createElement("option");
          option.value     = text;
          option.innerHTML = text;
          document.getElementById("dashboardSelector").appendChild(option);
        } catch (e) {
            document.write(e);
        }
        <?php
        //return $this->getPanels($key->email, $key->dashboard_id, $key->url, $key->token);
      }
    }
    ?>
}

function updateDashboard(){
  var select = document.getElementById("dashboardSelector")
  var value = select.options[select.selectedIndex].value;

  if(value != ""){
    document.getElementById("updateDashboard").submit();
  }
}

</script>

</head>
<body onload="javascript: create_frames(); getDashboardsIDs();">

<form id='devices' method="POST"  action="devices">

  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="arg" id="arg" value="">
  <input type ="hidden" name="currentaccount" id="currentaccount" value="{{ $email }}">

  <div class="navbar">

    <div class="dropdown">

      <button class="dropbtn" disabled>DASHBOARD
        <i class="fa fa-caret-down"></i>
      </button>

      <div class="dropdown-content">
        <a href="javascript: update_config();">Change config</a>
      </div>
    </div>

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

@if(isset($error) &&strlen($error) != 0)
  <h4 class="shake" style="color: red">{{$error}}</h4>
@else
<!-- Show the following lines only if $error is empty-->

<!-- dropdown Time range -->
<span class="custom-dropdown" >
  <select name="TimeRange" onchange="framesTimeUpdate()">
    <option value="">Time Range</option>
    <option value="now-1h">1h</option>
    <option value="now-3h">3h</option>
    <option value="now-6h">6h</option>
    <option value="now-12h">12h</option>
    <option value="now-24h">24h</option>
    <option value="now-48h">48h</option>
    <option value="now-1w">1 week</option>
    <option value="now-1M">1 month</option>
    <option value="now-1Y">1 year</option>
  </select>
</span>

<form id="updateDashboard" action="update_dashboard" method="POST">

  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type ="hidden" name="currentaccount" id="currentaccount" value="{{ $email }}">

  <span class="custom-dropdown">
    <select name="dashboardSelector" id="dashboardSelector" onchange="updateDashboard()">
      <option value="">Available Dashboards</options>
    </select>
  </span>
</form>

<p align="center"> Account: {{$email}}</p>    <p>Current Dashboard ID: {{$dashboardID}}</p>
<p id="currentRange" align="center">Current Time Range: 1h</p>
<br>


  <!-- if the query request "refresh=Ns" (wehere N is number of seconds and s is seconds), is added and the option "to=" is set to "now",
       the chart will auto refresh, without need to update the frame.
       Of course, you need to add the same refresh option value in grafana admin panel.
  <iframe id="humidity_frame" src="http://panel.seewebiot.it:3000/d-solo/fbqnYo5mz/seewebiot?orgId=1&from=now-1h&to=now&panelId=8&refresh=5s" width="800" height="300" frameborder="0"></iframe>
  <iframe id="temperature_frame" src="http://panel.seewebiot.it:3000/d-solo/fbqnYo5mz/seewebiot?orgId=1&panelId=10&from=now-1h&to=now&refresh=5s" width="800" height="300" frameborder="0"></iframe>
  <iframe id="airPollution_frame" src="http://panel.seewebiot.it:3000/d-solo/fbqnYo5mz/seewebiot?orgId=1&from=now-1h&to=now&panelId=6&refresh=5s" width="800" height="300" frameborder="0"></iframe>
  <iframe id="UV_frame" src="http://panel.seewebiot.it:3000/d-solo/fbqnYo5mz/seewebiot?orgId=1&from=now-1h&to=now&panelId=12&refresh=5s" width="800" height="300" frameborder="0"></iframe>
  <iframe id="pm10_frame" src="http://panel.seewebiot.it:3000/d-solo/fbqnYo5mz/seewebiot?orgId=1&from=now-1h&to=now&panelId=11&refresh=5s" width="800" height="300" frameborder="0"></iframe>
  <iframe id="pm25_frame" src="http://panel.seewebiot.it:3000/d-solo/fbqnYo5mz/seewebiot?orgId=1&from=now-1h&to=now&panelId=4&refresh=5s" width="800" height="300" frameborder="0"></iframe>
-->

 @endif

</body>
</html>
