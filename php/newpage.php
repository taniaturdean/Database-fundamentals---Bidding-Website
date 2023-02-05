<?php
session_start();
require('database.php')

?>

<html>
<head>
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>


    <script>
        $(document).ready(function() {
            $("#inputbox").keyup(function() {
                email = $("#inputbox").val();
                // check the database for a user with the same username
                $.post("check_user.php", {email:email}, function(data) {
                    console.log(data)
                    $('#output').html(data);
                });

            });
        });
        function hasValue(elem) {
            return $(elem).filter(function() {return $(this).val(); }).length > 0;
}

        $(document).ready(function() {
            $("#pswd2, #pswd1").keyup(function() {
                console.log("one key pressed");
                if(hasValue(pswd2) && hasValue(pswd1)) {
                    if($("#pswd1").val() != $("#pswd2").val()) {
                        $("#output3").html("passwords don't match");
                    }
                    else {
                        $("#output3").html("passwords do match");
                    }
                }
            });
        });


    </script>

</head>
<body>
<form>
    <label for="text">check email:</label>
    <input id="inputbox" type="text" name="name">
</form>
<p id="output"></p>

<form>
    <label for="pswd1">password box:</label>
    <input id="pswd1" type="text" name="name">
</form>
<p id="output2"></p>
<form>
    <label for="pswd2">confirm password box:</label>
    <input id="pswd2" type="text" name="name">
</form>
<p id="output3"></p>
</body>
</html>