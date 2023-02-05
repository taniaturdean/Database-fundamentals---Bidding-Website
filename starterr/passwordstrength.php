<?php
$password = $_POST["password"];
function passwordStrength($password) {
    /* this function will test password strength based off a score out of 5
    outputs:
        - 0: no entry
        - 1: very weak
        - 2: weak
        - 3: medium
        - 4: strong
        - 5: very strong
    */
    $uppercase = strlen(preg_replace('![^A-Z]+!', '', $password));
    $lowercase = strlen(preg_replace('![^a-z]+!', '', $password));
    // $number    = preg_match('@[0-9]@', $password);
    $number = strlen(preg_replace('![^0-9]+!', '', $password));

    $specialChars = preg_match_all('/[!@#$%^&*()]/',$password);
    $ret = array($uppercase, $lowercase, $number, $specialChars);
    $score = 0;
    // at least one upper and so on...
    if ($uppercase >= 1) {
        $score ++;
    }
    if ($lowercase >= 1) {
        $score ++;
    }
    if ($number >= 1) {
        $score ++;
    }
    if ($specialChars >=1) {
        $score ++;
    }
    if ($uppercase + $lowercase + $number + $specialChars >= 8) {
        $score ++;
    }
    $password_strength_arr = ["no entry", "very weak", "weak", "medium", "strong", "Excellent"];
    $strength_col = ["red", "orange", "yellow", "greenyellow", "green", "blue"];
    return ["Password: ".$password_strength_arr[$score], $strength_col[$score]];
}
echo json_encode(passwordStrength($password));
?>
