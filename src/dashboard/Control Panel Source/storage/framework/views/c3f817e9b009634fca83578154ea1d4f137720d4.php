<html>
<head>
  <?php //echo $email ?>
</head>

<link rel="stylesheet" type="text/css" href="css/delete.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/combo_box.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/dropdown_menu.css" media="screen" />

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
<body >

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

<br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php if(isset($msg) && strlen($msg) != 0): ?>
  <h4 color="blue" style="color: green"><?php echo e($msg); ?></h4>
<?php elseif(isset($error) &&strlen($error) != 0): ?>
  <h4 class="shake" style="color: red"><?php echo e($error); ?></h4>
<?php endif; ?>


<div class="grid">

<form action="reg_device" method="POST" class="form login">

  <!-- add the csrf_token inside query, otherwise an error will be returned by controller -->
  <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

  <!-- send to controller the current account email -->
  <input type ="hidden" name="currentaccount" id="currentaccount" value="<?php echo e($email); ?>">

  <div class="form__field">
    <input id="register_ID" type="text" name="ID" class="form__input" placeholder="ID" required>
  </div>

  <div class="form__field">
    <input id="device_NAME" type="text" name="device_Name" class="form__input" placeholder="Device Name" required>
  </div>

  <div class="form__field">
    <input type="submit" value="Add to your database">
  </div>
</div>

</form>


</body>
</html>
