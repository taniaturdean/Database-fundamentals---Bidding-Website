<?php 
include_once('session.php');
include_once("header.php");
include('database.php');
?>
<head>
    <title>    </title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

        <script src="js/password_email_functions.js"></script>
</head>


<div class="container">
<h2 class="my-3">Register new account</h2>
    <script>
        console.log('working');
    </script>
<?php 

if (isset($_GET['result']) and $_GET['result']=='validation_error') {

  if( isset($_SESSION['status']) && $_SESSION['status'] === 'error'){
      $errors = $_SESSION['errors'];
      foreach($errors as $e){
        echo "<i style='color:red;tab-size:2'>".$e."</i><br>";
      }
  }
}
?>

<!-- Registration form -->
<form method="POST" action="process_registration.php">

  <div class="form-group row">
    <label for="accountType" class="col-sm-2 col-form-label text-right">Registering as a:</label>
	  <div class="col-sm-10">

	  <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="accountType" id="accountBuyer" value="buyer" checked>
        <label class="form-check-label" for="accountBuyer">Buyer</label>
    </div>

    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="accountType" id="accountSeller" value="seller">
      <label class="form-check-label" for="accountSeller">Seller</label>
    </div>

      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="accountType" id="accountBoth" value="both">
        <label class="form-check-label" for="accountBoth">Both</label>
      </div>

      <small id="accountTypeHelp" class="form-text-inline text-muted"><span class="text-danger">* Required.</span></small>
	  </div>

  </div>

  <div class="form-group row">
    <label for="firstname" class="col-sm-2 col-form-label text-right">Firstname</label>
	  <div class="col-sm-10">
      <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Your Firstname">
      <small id="firstnameHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
	  </div>
  </div>

  <div class="form-group row">
    <label for="lastname" class="col-sm-2 col-form-label text-right">Lastname</label>
	  <div class="col-sm-10">
      <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Your Lastname">
      <small id="lastnameHelp" class="form-text text-muted"><span class="text-danger">* Required.</span></small>
	  </div>
  </div>


  <div class="form-group row">
    <label for="email1" class="col-sm-2 col-form-label text-right">Email</label>
	  <div class="col-sm-10">
      <input type="text" class="form-control" id="email1" name="email" placeholder="Email">
      <small id="emailHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> <span id="emailcheck"></span></small>
    </div>
  </div>


  <div class="form-group row">
    <label for="password1" class="col-sm-2 col-form-label text-right">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
      <small id="passwordHelp" class="form-text text-muted"><span class="text-danger">* Required.</span>  <span id="passwordStrength"></span></small>
    </div>
    
  </div>

  <div class="form-group row">
    <label for="passwordConfirmation" class="col-sm-2 col-form-label text-right">Repeat password</label>
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

      </span> <span id="passwordcheck"></span></small>
    </div>
      
  </div>

  <!-- Add interests --> 
  <div class="form-group row">
    
    <label for="interests" class="col-sm-2 col-form-label text-right">Select Interests: </label>
    
    <div class="col-sm-10">
      <div class="form-check form-check-inline">

        <input class="form-check-input" type="checkbox" name="interests[]" id="clothes" value="1" >
        <label class="form-check-label" for="books">Clothing </label>

        <input class="form-check-input" type="checkbox" name="interests[]" id="electronics" value="2" >
        <label class="form-check-label" for="clothes">Electronics </label>

        <input class="form-check-input" type="checkbox" name="interests[]" id="homeware" value="3" >
        <label class="form-check-label" for="electronics">Homeware </label>

        <input class="form-check-input" type="checkbox" name="interests[]" id="furniture" value="4" >
        <label class="form-check-label" for="electronics">Furniture </label>

        <input class="form-check-input" type="checkbox" name="interests[]" id="jewelry" value="5" >
        <label class="form-check-label" for="electronics">Jewelry </label>

        <input class="form-check-input" type="checkbox" name="interests[]" id="garden_equipment" value="6" >
        <label class="form-check-label" for="electronics">Garden Equipment </label>

        <script type="text/javascript">
          var limit = 3;
          $('input.form-check-input').on('change', function(evt) {
            if($(this).siblings(':checked').length >= limit) {
                this.checked = false;
            }
          });
        </script>
      </div>
      <small id="threeCategoriesHelp" class="form-text text-muted"><span class="text-danger">* Three required.
    </div>
    
  </div>

  <div class="form-group row">
    <button type="submit" class="btn btn-primary form-control">Register</button>
  </div>

</form>

<div class="text-center">Already have an account? <a href="" data-toggle="modal" data-target="#loginModal">Login</a>

</div>

<?php include_once("footer.php")?>