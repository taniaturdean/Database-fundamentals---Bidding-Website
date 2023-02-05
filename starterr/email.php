<?php
include_once('database.php');
include_once("debug_to_console.php");

// cron statement for fatima's mac 
// * * * * * /Applications/MAMP/htdocs/Untitled/database-fundamentals/starter/email.php

    // start data base connection
    $conn = OpenConn();
    // our email: comp0178coursework@gmail.com
    // our password is our initals --> fcfsttfr1

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';
    
    # fit to your own laptop
    // require '/Applications/MAMP/bin/phpMyAdmin/vendor/autoload.php'; # fatima's path
    require 'C:/wamp64/apps/phpmyadmin5.1.1/vendor/autoload.php'; # fergus' path

function outbidNotif($firstname, $email, $itemname, $bid){
        $mail = new PHPMailer(true);
    
        //Server settings
         $mail->isSMTP();                                            //Send using SMTP
         $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
         $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
         $mail->Username   = 'comp0178coursework@gmail.com';          //SMTP username
         $mail->Password   = 'gcfkcenmrkvvoeri';                     //SMTP password
         $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
         $mail->Port       = 465;  
    
         $mail->setFrom('comp0178coursework@gmail.com', 'Database Fundamentals');
         $mail->addAddress($email, $firstname);                     //Add a recipient
    
         $mail->isHTML(true);                                  //Set email format to HTML
         $mail->Subject = 'You were outbid on '.$itemname;
         $mail->Body    = 'Hey '.$firstname.', you were outbid on '.$itemname.'. The newest bid was £'.$bid.'. Log in and bid again to have a chance at winning!';
     
         $mail->send(); 

}

function watchlistNotif($firstname, $email, $itemname, $bid){
    
    $mail = new PHPMailer(true);

    //Server settings
     $mail->isSMTP();                                            //Send using SMTP
     $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
     $mail->Username   = 'comp0178coursework@gmail.com';          //SMTP username
     $mail->Password   = 'gcfkcenmrkvvoeri';                     //SMTP password
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
     $mail->Port       = 465;  

     $mail->setFrom('comp0178coursework@gmail.com', 'Database Fundamentals');
     $mail->addAddress($email, $firstname);                     //Add a recipient

     $mail->isHTML(true);                                  //Set email format to HTML
     $mail->Subject = 'New bid on item '.$itemname;
     $mail->Body    = 'Hey '.$firstname.', a new bid has been place on item '.$itemname.'<br><br> The new bid is £'.$bid.'<br><br> Log in to place a new bid.';
 
     $mail->send();


}


function sendtobuyer($itemname, $email, $firstname, $bid){
    
    $mail = new PHPMailer(true);

    //Server settings
     $mail->isSMTP();                                            //Send using SMTP
     $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
     $mail->Username   = 'comp0178coursework@gmail.com';          //SMTP username
     $mail->Password   = 'gcfkcenmrkvvoeri';                     //SMTP password
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
     $mail->Port       = 465;  

     $mail->setFrom('comp0178coursework@gmail.com', 'Database Fundamentals');
     $mail->addAddress($email, $firstname);                     //Add a recipient

     $mail->isHTML(true);                                  //Set email format to HTML
     $mail->Subject = 'You won the '.$itemname;
     $mail->Body    = 'Hey '.$firstname.', your bid of £'.$bid.' on the '.$itemname.' has won! <br><br> The seller will contact you shortly to send the item.';
 
     $mail->send();


}

function sendtobuyerreserve($itemname, $email, $firstname, $bid){
    
    $mail = new PHPMailer(true);

    //Server settings
     $mail->isSMTP();                                            //Send using SMTP
     $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
     $mail->Username   = 'comp0178coursework@gmail.com';          //SMTP username
     $mail->Password   = 'gcfkcenmrkvvoeri';                     //SMTP password
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
     $mail->Port       = 465;  

     $mail->setFrom('comp0178coursework@gmail.com', 'Database Fundamentals');
     $mail->addAddress($email, $firstname);                     //Add a recipient

     $mail->isHTML(true);                                  //Set email format to HTML
     $mail->Subject = 'Your pending win for '.$itemname;
     $mail->Body    = 'Hey '.$firstname.', your bid of £'.$bid.' on the '.$itemname.' was the highest bid! <br><br> However, your bid did not meet the minimum reserve price set by the seller. Therefore, the seller is not obligated to sell - please wait for the seller to reach out to you.';
 
     $mail->send();


}

function sendtoseller($itemname, $email, $firstname, $bid, $buyeremail) {
    $mail = new PHPMailer(true);

    //Server settings
     $mail->isSMTP();                                            //Send using SMTP
     $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
     $mail->Username   = 'comp0178coursework@gmail.com';          //SMTP username
     $mail->Password   = 'gcfkcenmrkvvoeri';                     //SMTP password
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
     $mail->Port       = 465;  

     $mail->setFrom('comp0178coursework@gmail.com', 'Database Fundamentals');
     $mail->addAddress($email, $firstname);                     //Add a recipient

     $mail->isHTML(true);                                  //Set email format to HTML
     $mail->Subject = 'Auction ended on '.$itemname;
     $mail->Body    = 'Hey '.$firstname.', your auction for the '.$itemname.' has ended! <br><br> The highest bid was £'.$bid.'. Please contact the buyer to arrange shipping at '.$buyeremail.'<br>Add another listing at Auction House!.';
 
     $mail->send();
    
}

function sendtosellerreserve($itemname, $email, $firstname, $bid, $buyeremail, $reserveprice) {
    $mail = new PHPMailer(true);

    //Server settings
     $mail->isSMTP();                                            //Send using SMTP
     $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
     $mail->Username   = 'comp0178coursework@gmail.com';          //SMTP username
     $mail->Password   = 'gcfkcenmrkvvoeri';                     //SMTP password
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
     $mail->Port       = 465;  

     $mail->setFrom('comp0178coursework@gmail.com', 'Database Fundamentals');
     $mail->addAddress($email, $firstname);                     //Add a recipient

     $mail->isHTML(true);                                  //Set email format to HTML
     $mail->Subject = 'Reserve price not met for '.$itemname;
     $mail->Body    = 'Hey '.$firstname.', your auction for the '.$itemname.' has ended! <br><br> The highest bid was £'.$bid.' which was lower than your reserve price of £'.$reserveprice.' . Therefore, you have no obligation to sell, however, you must contact the buyer at '.$buyeremail.' about your decision. <br>Add another listing at Auction House!.';
 
     $mail->send();
    
}

function failedauctionemail($itemname, $email, $firstname){
    $mail = new PHPMailer(true);

    //Server settings
     $mail->isSMTP();                                            //Send using SMTP
     $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
     $mail->Username   = 'comp0178coursework@gmail.com';          //SMTP username
     $mail->Password   = 'gcfkcenmrkvvoeri';                     //SMTP password
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
     $mail->Port       = 465;  

     $mail->setFrom('comp0178coursework@gmail.com', 'Database Fundamentals');
     $mail->addAddress($email, $firstname);                     //Add a recipient

     $mail->isHTML(true);                                  //Set email format to HTML
     $mail->Subject = 'Auction ended: '.$itemname;
     $mail->Body    = 'Hey '.$firstname.', we have some bad news. Your auction for the '.$itemname.' did not recieve any bids. Try your luck again at Auction House.';
 
     $mail->send();

}

$conn = OpenConn();
// checking whether time for an auction is up which is running continously on database.php
$sql = "SELECT * FROM items WHERE endDate<CURRENT_TIMESTAMP AND email=0";
$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result)) {
    
    // call the function when there is a result 
    while($row = mysqli_fetch_assoc($result)) {
        // item name
        $itemname = $row['itemName'];
        $itemid = $row['item_id'];

        // seller email
        $sellersql="SELECT * FROM users WHERE user_id=(SELECT user_id FROM items WHERE item_id=$itemid)";
        $sellerresult = mysqli_query($conn,$sellersql); 
        $sellerrow = mysqli_fetch_assoc($sellerresult);
        $selleremail = $sellerrow['email'];
        $sellername= $sellerrow['firstname'];

        // make sure there are bids on the item 
        $query = "SELECT * FROM bids WHERE item_id=$itemid";
        $res = mysqli_query($conn,$query);
        $sqlupdate = "UPDATE items SET email=1 WHERE item_id=$itemid";
        if (mysqli_query($conn,$sqlupdate)){
            debug_to_console('success');
        }

        // if there are bids on the item
        if (mysqli_num_rows($res)) {
            // max bid 
            $bidsql = "SELECT MAX(bid_price) FROM bids WHERE item_id=$itemid";
            $bidresult = mysqli_query($conn,$bidsql); 
            $bidrow = mysqli_fetch_array($bidresult);
            $maxbid = $bidrow[0];

            // buyer email from bids
            $buyersql="SELECT * FROM users WHERE user_id=(SELECT user_id FROM bids WHERE item_id=$itemid and bid_price=$maxbid)";
            $buyerresult = mysqli_query($conn,$buyersql); 
            $buyerrow = mysqli_fetch_assoc($buyerresult);
            $buyeremail = $buyerrow['email'];
            $buyername = $buyerrow['firstname'];

            // check if reserve price was set & met - because then seller is not obligated
            $reservesql = "SELECT reservePrice FROM items WHERE item_id=$itemid";
            $reserveresult = mysqli_query($conn,$reservesql); 
            $reserverow = mysqli_fetch_array($reserveresult);
            $reservePrice = $reserverow[0];
            
            // compare res to max bid
            if ($reservePrice != NULL){
                if ($maxbid < $reservePrice) {
                    sendtobuyerreserve($itemname, $buyeremail, $buyername, $maxbid);
                    sendtosellerreserve($itemname, $selleremail, $sellername, $maxbid, $buyeremail,$reservePrice);
                }
                else {
                    $query = "UPDATE bids SET winner=1 WHERE item_id=$itemid AND bid_price=$maxbid";
                    if (mysqli_query($conn,$query)){
                        debug_to_console('success');
                    }                    
                    sendtobuyer($itemname, $buyeremail, $buyername, $maxbid);
                    sendtoseller($itemname, $selleremail, $sellername, $maxbid, $buyeremail);
     
                }
            }

            else {
                // call the function 
                $query = "UPDATE bids SET winner=1 WHERE item_id=$itemid AND bid_price=$maxbid";
                if (mysqli_query($conn,$query)){
                    debug_to_console('success');
                }
                sendtobuyer($itemname, $buyeremail, $buyername, $maxbid);
                sendtoseller($itemname, $selleremail, $sellername, $maxbid, $buyeremail);
            }

        }
        // if no bids
        else {
            // call the unsuccessful auction function
            failedauctionemail($itemname, $selleremail, $sellername);
        }



    }   

}

?>