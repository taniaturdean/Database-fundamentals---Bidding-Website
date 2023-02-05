<?php 
include_once('session.php');
include_once("header.php");
include('database.php');
?>
<head>
    <title>   </title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>


<body>
<div id="success_and_errors">
<?php
if( isset($_SESSION['status']) && $_SESSION['status'] === 'password error'){
      $errors = $_SESSION['password errors'];
      echo 'Password change failed';
      foreach($errors as $e){
        echo "<br>$e";
      }
      unset($_SESSION['status']);
      unset($_SESSION["password errors"]);
  }
if(isset($_SESSION['password_change']) && $_SESSION['password_change'] ==='yes') {
    echo "password successfully changed";
    unset($_SESSION['password_change']);
}
?>
</div>
<div id="passwordchange">
    <form method="POST" action="change_password.php">

  <div class="form-group row">
    <label for="password1" class="col-sm-2 col-form-label text-right">New Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
      <small id="passwordHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
    </div>
    <p id="passwordStrength"></p>
  </div>

  <div class="form-group row">
    <label for="passwordConfirmation" class="col-sm-2 col-form-label text-right">Repeat New Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="passwordConfirmation" name="passwordConfirmation" placeholder="Enter password again">
      <small id="passwordConfirmationHelp" class="form-text text-muted"><span class="text-danger">* Required.
      <?php 
        if (isset($_GET['error'])){
          if ($_GET['error']='password') {
            echo '<b style="color:red;">Error: Passwords do not match</b>';
          }
        }
      ?>

      </span></small>
    </div>
      <p id="passwordcheck"></p>
  </div>

  <div class="form-group row">
    <button type="submit" class="btn btn-primary form-control">Submit</button>
  </div>


</div>
</body>

<?php include_once("footer.php")?>