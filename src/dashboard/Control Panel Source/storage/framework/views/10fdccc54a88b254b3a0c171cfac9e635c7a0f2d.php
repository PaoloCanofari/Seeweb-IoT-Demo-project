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

    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
    <input type="hidden" name="arg" id="arg" value="">
    <input type ="hidden" name="currentaccount" id="currentaccount" value="<?php echo e($email); ?>">

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

      <a  href="<?php echo e(url('/')); ?>">LOGOUT</a>

    </div>
  </form>

  <br><br><br>

  <!-- if there are some devices, add them to a table-->

    <?php if(isset($error) && strlen($error) != 0): ?>
      <h4 class="shake" style="color: red"><?php echo e($error); ?></h4>
    <?php else: ?>

    <table class="tg" align="center">
      <tr>
        <th style="font-weight:bold">Dashboard Name</th>
        <th style="font-weight:bold">Dashboard ID</th>
        <th style="font-weight:bold">Dashboard URL</th>
      </tr>
      <?php $__currentLoopData = $dashboards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <th><?php echo e($key->Dashboard_Name); ?></th>
        <th><?php echo e($key->dashboard_id); ?></th>
        <th><?php echo e($key->url."d/".$key->dashboard_id); ?> </th>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>

    <br><br><br>

<div class="grid">
  <form action="remove_db" method="POST" class="form login">

    <!-- add the csrf_token inside query, otherwise an error will be returned by controller -->
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

    <!-- send to controller the current account email -->
    <input type ="hidden" name="currentaccount" id="currentaccount" value="<?php echo e($email); ?>">

    <div class="form__field">
      <input id="remove_db" type="text" name="dashboard_id" class="form__input" placeholder="dashboard_id" required>
    </div>

    <div class="form__field">
      <input onclick="return confirm('Are you sure to remove this dashboard from your dashboard list?');" type="submit" value="Remove Dashboard" >
</div>

    <?php endif; ?>

</body>
</html>
