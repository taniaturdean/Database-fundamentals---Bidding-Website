/* here is an asynchronous ajax call to check the database when creating a new user*/
$(document).ready(function() {
    $("#email1").keyup(function() {
        email = $("#email1").val();
        $.post("check_user.php", {desired_function: 'check_email', email:email}, function(data) {
            $('#emailcheck').html(data);
        });
    });
});
function hasEntry(inpt) {
  return $(inpt).filter(function() {return $(this).val(); }).length > 0;
}
/* we might want another one which checks the passwords match, might need to be done in more elegant way*/
$(document).ready(function() {
    $("#passwordConfirmation,#password1").keyup(function() {
      if(hasEntry(passwordConfirmation) && hasEntry(password1)) {
        if($("#passwordConfirmation").val() != $("#password1").val()) {
            $("#passwordcheck").html("passwords don't match").css("color", "red");
        }
        else {
            $("#passwordcheck").html("passwords do match").css("color", "green");
        }
    }
    });
});
// jquery code for checking strength of password
$(document).ready(function() {
    $("#password1").keyup(function() {
      password = $("#password1").val();
      $.post("passwordstrength.php", {password:password}, function(data) {
        // turning the string into an object
        jsondata = JSON.parse(data);
          $("#passwordStrength").html(jsondata["0"]).css("color", jsondata["1"]);
      });
    });
});