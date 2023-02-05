<?php
include_once("database.php");
// display_time_remaining:
// Helper function to help figure out what time to display
function display_time_remaining($interval) {

    if ($interval->days == 0 && $interval->h == 0) {
      // Less than one hour remaining: print mins + seconds:
      $time_remaining = $interval->format('%im %Ss');
    }
    else if ($interval->days == 0) {
      // Less than one day remaining: print hrs + mins:
      $time_remaining = $interval->format('%hh %im');
    }
    else {
      // At least one day remaining: print days + hrs:
      $time_remaining = $interval->format('%ad %hh');
    }

  return $time_remaining;

}

// print_listing_li:
// This function prints an HTML <li> element containing an auction listing
function print_listing_li($item_id, $img_url, $title, $desc, $price, $num_bids, $end_time) {

  // Truncate long descriptions
  if (strlen($desc) > 250) {
    $desc_shortened = substr($desc, 0, 250) . '...';
  }
  else {
    $desc_shortened = $desc;
  }
  
  // Fix language of bid vs. bids
  if ($num_bids == 1) {
    $bid = ' bid';
  }
  else {
    $bid = ' bids';
  }

  // Calculate time to auction end

  $now = new DateTime();
  $end_time = new DateTime($end_time);

  if ($now > $end_time) {
    $time_remaining = 'This auction has ended';
  }
  
  else {
    // Get interval:
    $time_to_end = date_diff($now, $end_time);
    $time_remaining = display_time_remaining($time_to_end) . ' remaining';
  }

  // Print HTML
  echo('
    <li class="list-group-item d-flex justify-content-between">
    <div class="p-2 mr-5"><h5><a href="listing.php?item_id=' . $item_id . '">' . $title . '</a></h5>' . $desc_shortened . '</div>
    <div class="text-center text-nowrap"><span style="font-size: 1.5em">£' . number_format($price, 2) . '</span><br/>' . $num_bids . $bid . '<br/>' . $time_remaining . '</div>  
    <div><img src="uploads/'.$img_url.'" width="150" height="150"></div> 
    </li>');
}

// function to find total number of bids for an item 
function bidNums($item_id){
  
  $conn = OpenConn();

  $sql = "SELECT COUNT(*) AS total FROM bids WHERE item_id=$item_id";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result);
  //echo('<p>'.$row['total'].'</p>');
  $numbids = $row['total'];
  CloseConn($conn);

  return $numbids;

}
// function for bids page
function print_bids_li($item_id, $img_url, $title, $desc, $price, $num_bids, $end_time, $your_bid) {

  // Truncate long descriptions
  if (strlen($desc) > 250) {
    $desc_shortened = substr($desc, 0, 250) . '...';
  }
  else {
    $desc_shortened = $desc;
  }
  
  // Fix language of bid vs. bids
  if ($num_bids == 1) {
    $bid = ' bid';
  }
  else {
    $bid = ' bids';
  }

  // Calculate time to auction end

  $now = new DateTime();
  $end_time = new DateTime($end_time);

  if ($now > $end_time) {
    $time_remaining = 'This auction has ended';
  }
  
  else {
    // Get interval:
    $time_to_end = date_diff($now, $end_time);
    $time_remaining = display_time_remaining($time_to_end) . ' remaining';
  }

  // Print HTML
  echo('
    <li class="list-group-item d-flex justify-content-between">
    <div class="p-2 mr-5"><h5><a href="listing.php?item_id=' . $item_id . '">' . $title . ' </a> - Your highest bid: £'.$your_bid.'</h5>' . $desc_shortened . '</div>
    <div><img src="uploads/'.$img_url.'" width="150" height="150">
    <div class="text-center text-nowrap"><span style="font-size: 1.5em">£' . number_format($price, 2) . '</span><br/>' . $num_bids . $bid . '<br/>' . $time_remaining . '</div>  
    </div> 
    </li>
  <br>');
}


function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}


?>