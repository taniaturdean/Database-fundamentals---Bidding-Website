<?php
include_once("database.php");
include_once("session.php");
include_once('email.php');

// start data base connection
$conn = OpenConn();


// TODO: Extract $_POST variables, check they're OK, and attempt to make a bid.
// Notify user of success/failure and redirect/give navigation options.
$bid = $_POST['bid'];
$itemid = $_GET['id'];
$errors = [];

// TODO: send user back if they are just a seller
if ($_SESSION['account_type'] == "seller"){
    $error[] = "sellers cannot place bids";
    header('Location:listing.php?item_id='.$itemid.'&result=seller');
    die();
}

// TODO: send user back if they are not logged in 
if (!isset($_SESSION['logged_in'])){
    header('Location:listing.php?item_id='.$itemid.'&result=login');
    die();

}

// TODO: send user back if bid is empty
if (empty($_POST['bid'])){
    header('Location:listing.php?item_id='.$itemid.'&result=empty');
    die();

}




// validate the bid 
// grab item info about from the item id
$sql = "SELECT * FROM items WHERE item_id=$itemid";
$result = mysqli_query($conn,$sql) or exit(mysqli_error()); 
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

// start Price
$startPrice = $row["startPrice"];

// needs to be above startPrice 
if ($bid < $startPrice) {
    $errors[] = "bid price needs to be above start price";
}

// TODO: check if its higher than max bid
$sql = "SELECT MAX(bid_price) FROM bids WHERE item_id=$itemid";
$sqlresult = mysqli_query($conn,$sql) or exit(mysqli_error()); 
$res = mysqli_fetch_array($sqlresult);

$maxbid =$res[0];

if ($bid <= $maxbid){
    $errors[] = "you cannot submit a bid lower than the current highest bid";
}

// you can't place a bid on your own item
$sellerid = $row["user_id"];
// grab user id from session
$userloggedin = $_SESSION['userid'];

if ($sellerid == $userloggedin){
    $errors[] = "you cannot submit a bid on your own item";
}


// TODO: needs to be before end date
// timestamp
$current_timestamp = date('Y-m-d\TH:i');


// if there are errors send back to page with errors
if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['status'] = 'error';
    header('Location:listing.php?item_id='.$itemid.'&result=validation_error');
    die();
}

// get variables for insert query 

// find the bid id we should use
$findidsql = "SELECT MAX(bid_id) FROM bids";
$result = mysqli_query($conn,$findidsql) or exit(mysqli_error()); 
$row = mysqli_fetch_array($result);
if ($row[0]==NULL){
    $id=1;
}
else{
    $id = $row[0]+1;
}

// grab user id
$userid = $_SESSION['userid'];

// grab item name we will need it for the email 
$sqlitemname = "SELECT itemName FROM items WHERE item_id=$itemid";
$itemnameres = mysqli_query($conn,$sqlitemname) or exit(mysqli_error()); 
$row = mysqli_fetch_array($itemnameres);
$itemname = $row[0];



// if there is a big prior then get the user id to inform them of last bid
$sqllastbid = "SELECT user_id FROM bids where item_id=$itemid and bid_price=(SELECT MAX(bid_price) from bids where item_id=$itemid)";
$lastbidres=mysqli_query($conn,$sqllastbid); 
if (mysqli_num_rows($lastbidres)){
    $rowlastbid=mysqli_fetch_assoc($lastbidres);
    $userid_lastbidder = $rowlastbid['user_id'];
    // last highest bidder info
    $bidderquery = "SELECT firstname, email FROM users WHERE user_id=$userid_lastbidder";
    $resbidder=mysqli_query($conn,$bidderquery);
    $rowbidder = mysqli_fetch_assoc($resbidder);
    $outbidemail = $rowbidder['email'];
    $outbidname = $rowbidder['firstname']; 
}


// time to insert
$query = "INSERT INTO bids (bid_id, item_id, timestamp, bid_price, user_id) VALUES ('$id','$itemid','$current_timestamp','$bid','$userid')";

if (mysqli_query($conn, $query)) {
    // only if successful
    if ($userid != $userid_lastbidder && $userid_lastbidder != NULL){
        outbidNotif($outbidname,$outbidemail,$itemname,$bid);
    }
    
    // notify users from watchlist column 
    $sql = "SELECT * FROM watchlist WHERE itemid=$itemid";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result)) {


        while($row = mysqli_fetch_assoc($result)) {
           

            // send email to each person on the watchlist - unless they are the person you just bid
            $watchlistuser = $row['userid'];
            // get user info
            $usersql = "SELECT firstname, email FROM users WHERE user_id=$watchlistuser";
            $userresult = mysqli_query($conn,$usersql); 
            $userrow = mysqli_fetch_assoc($userresult);
            
            // grab the info we need to call the email function
            $firstname =$userrow['firstname'];
            $email = $userrow['email'];

            // only run function if it's not the same user that placed the bid

            if ($watchlistuser != $userid) {
                watchlistNotif($firstname, $email, $itemname, $bid);
            }

        }
    }

 
    header('Location:listing.php?item_id='.$itemid.'&result=success');
    CloseConn($conn);

} 
else {
    $_SESSION['status'] = 'error';
    $_SESSION['errors'] = $errors;
    header('Location:listing.php?item_id='.$itemid.'&result=my_sql_error');
    CloseConn($conn);

}





?>