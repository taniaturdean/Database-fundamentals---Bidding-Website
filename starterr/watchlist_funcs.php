 <?php
 include_once('database.php');
 include_once('session.php');


if (!isset($_POST['functionname']) || !isset($_POST['arguments'])) {
  return;
}

$conn = OpenConn();
// Extract arguments from the POST variables:
$func_args = $_POST['arguments'];
$item_id = $func_args[0];
$user_id = $func_args[1];

if ($_POST['functionname'] == "add_to_watchlist") {
  // TODO: Update database and return success/failure.
    $sql="INSERT INTO `watchlist`(`userid`, `itemid`) VALUES ($user_id,$item_id)";
    $result = mysqli_query($conn,$sql);
    $res = "success";
}
else if ($_POST['functionname'] == "remove_from_watchlist") {
  // TODO: Update database and return success/failure.
  
  $sql="DELETE FROM `watchlist` WHERE userid= $user_id and itemid = $item_id";
  $result = mysqli_query($conn,$sql);
  $res = "success";
}

// Note: Echoing from this PHP function will return the value as a string.
// If multiple echo's in this file exist, they will concatenate together,
// so be careful. You can also return JSON objects (in string form) using
// echo json_encode($res).
echo $res;

?>
