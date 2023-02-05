<?php 
include_once("header.php");
include_once("database.php");
include_once("session.php");
include_once("debug_to_console.php");
?>

<div class="container my-5">

<?php


$errors = [];

// This function takes the form data and adds the new auction to the database.

/* TODO #1: Connect to MySQL database (perhaps by requiring a file that
            already does this). */

$conn = OpenConn();


/* TODO #2: Extract form data into variables. Because the form was a 'post'
            form, its data can be accessed via $POST['auctionTitle'], 
            $POST['auctionDetails'], etc. Perform checking on the data to
            make sure it can be inserted into the database. If there is an
            issue, give some semi-helpful feedback to user. */


// check title 
if(!empty($_POST['auctionTitle'])) {
    // remove special characters from the name and description 
    $title = mysqli_real_escape_string($conn, $_POST['auctionTitle']);
    
} 
else {
    $errors[] = 'auction title cannot be empty';
}

// check description - optional
// remove special characters from the name and description 
$details = mysqli_real_escape_string($conn, $_POST['auctionDetails']);

// check image

if ($_FILES['image']['size']== 0){
    $errors[] = 'please insert an image';
}
 // make sure its not too big 
if($_FILES['image']['size'] > 500000){
    $errors[] = 'image needs to be under 500KB';
}
// check type
$img_name = $_FILES['image']['name'];
$tmp_name = $_FILES['image']['tmp_name'];

$img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
$img_ex_lc = strtolower($img_ex);
$allowed_ex= array("jpg","jpeg","png");
if(in_array($img_ex_lc,$allowed_ex)){
    $new_img_name = uniqid("IMG-",true).'.'.$img_ex_lc;
    $img_upload_path = 'uploads/'.$new_img_name;
    /* move_uploaded_file($tmp_name,$img_upload_path);*/

}

else{
    $errors[] = 'needs to be jpg, jpeg, or png';
}


// check category 
if($_POST['auctionCategory']==="error"){
    $errors[] = 'please select a category';
}
else{
    //$category = mysqli_real_escape_string($conn, $_POST['auctionCategory']);
    $categoryid = $_POST['auctionCategory'];
}

// check starting price
if(!empty($_POST['auctionStartPrice'])){
    $startprice = $_POST['auctionStartPrice'];
}
else {
    $errors[] = 'enter a starting price';
}


// PAIN POINT !! check reserve price - optional 
// check if reserve price is less than start 
if (!empty($_POST['auctionReservePrice'])){

    if ($_POST['auctionReservePrice'] < $startprice){
        $errors[] = 'reserve price cannot be less than start price';
    }
    else {
        $reserveprice=$_POST['auctionReservePrice'];
    }

}
else {
    $reserveprice = NULL; 
}

// end date is required
if(!empty($_POST['auctionEndDate'])){
    // make sure the date is after today's date
    $enddate=$_POST['auctionEndDate'];
}
else {
    $errors[] = 'enter an end date';
}

// create a variable for today's date as start date = today's date
$startdate = date('Y-m-d\TH:i');

// automate a start date
if ($enddate < $startdate) {
    $errors[] = 'end date is in the past';
}

// TODO: THERE IS AN ERROR
if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['status'] = 'error';
    header('Location:create_auction.php?result=validation_error');
    die();
}


/* TODO #3: If everything looks good, make the appropriate call to insert
            data into the database. */
// add to database
else {

    // 1. find out item id

    $findidsql = "SELECT MAX(item_id) FROM items";
    $result = mysqli_query($conn,$findidsql) or exit(mysqli_error()); 
    $row = mysqli_fetch_array($result);
    if ($row[0]==NULL){
        $id=1;
    }
    else{
        $id = $row[0]+1;
    }

    // 2. find category id 

    // $query = "SELECT category_id FROM category WHERE category_name='$category'";
    // $result = mysqli_query($conn,$query) or exit(mysqli_error());
    // $row = mysqli_fetch_array($result);
    // $categoryid = $row[0];
    $userid = $_SESSION['userid'];

    if (!empty($reserveprice)){
        $sql = "INSERT INTO items (item_id, itemName, description, startPrice, reservePrice, startDate, endDate, image, category_id, user_id, email) VALUES ('$id', '$title', '$details', '$startprice', '$reserveprice' , '$startdate', '$enddate','$new_img_name', '$categoryid','$userid',0)";
    }
    else {
        $sql = "INSERT INTO items (item_id, itemName, description, startPrice, reservePrice, startDate, endDate, image, category_id, user_id,email) VALUES ('$id', '$title', '$details', '$startprice', NULL , '$startdate', '$enddate','$new_img_name', '$categoryid','$userid',0)";
    }
    if (mysqli_query($conn, $sql)) {
        // only if successful
        move_uploaded_file($tmp_name,$img_upload_path);
        header('Location:create_auction.php?result=success&itemid='.$id);
      

    }
    else {
        $_SESSION['status'] = 'error';
        $_SESSION['errors'] = $errors;
        header('Location:create_auction.php?result=mysql_error&cat='.$categoryid);
        CloseConn($conn);
    }

    

    
    // If all is successful, let user know.

    echo('<div class="text-center">Auction successfully created! <a href="listing.php?item_id='.$id.'">View your new listing.</a></div>');
}

?>

</div>


<?php include_once("footer.php")?>