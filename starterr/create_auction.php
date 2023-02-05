<?php 
include_once("header.php");
include_once("database.php");
include_once("session.php");
include_once("debug_to_console.php");
?>

<?php
// (Uncomment this block to redirect people without selling privileges away from this page)
// If user is not logged in or not a seller, they should not be able to
// use this page.

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] == 'buyer') {
    header('Location: browse.php');
}

// we need to check whether this form has previously processed:
if (isset($_GET['result'])) {
    if ($_GET['result'] == 'validation_error') {

        if (isset($_SESSION['status']) && $_SESSION['status'] === 'error') {
            $errors = $_SESSION['errors'];
            foreach ($errors as $e) {
                echo "$e <br>";
            }
        }
    } elseif ($_GET['result'] == "success") {
        $item = $_GET['itemid'];
        echo('<div class="text-center">Auction successfully created! <a href="listing.php?item_id='.$item.'">View your new listing.</a></div>');
    } elseif ($_GET['result'] == "mysql_error") {
        echo('<div class="text-center">Database connection error</div>');
        debug_to_console($_SESSION['errors']);
    }
}

?>

<div class="container">

<!-- Create auction form -->
<div style="max-width: 800px; margin: 10px auto">
  <h2 class="my-3">Create new auction</h2>
  <div class="card">
    <div class="card-body">
      <!-- Note: This form does not do any dynamic / client-side / 
      JavaScript-based validation of data. It only performs checking after 
      the form has been submitted, and only allows users to try once. You 
      can make this fancier using JavaScript to alert users of invalid data
      before they try to send it, but that kind of functionality should be
      extremely low-priority / only done after all database functions are
      complete. -->
      <form method="post" action="create_auction_result.php" enctype="multipart/form-data">
        <div class="form-group row">
          <label for="auctionTitle" class="col-sm-2 col-form-label text-right">Title of auction</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="auctionTitle" name="auctionTitle" placeholder="e.g. Black mountain bike">
            <small id="titleHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> A short description of the item you're selling, which will display in listings.</small>
          </div>
        </div>

        <div class="form-group row">
          <label for="auctionDetails" class="col-sm-2 col-form-label text-right">Details</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="auctionDetails" name="auctionDetails" rows="4"></textarea>
            <small id="detailsHelp" class="form-text text-muted">Full details of the listing to help bidders decide if it's what they're looking for.</small>
          </div>
        </div>

        <div class="form-group row">
          <label for="image" class="col-sm-2 col-form-label text-right">Image </label>
          <div class="col-sm-10">
            <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
            <small id="titleHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> Must be jpg, jpeg, or png & under 500KB</small>
          </div>
        </div>

        <div class="form-group row">
          <label for="auctionCategory" class="col-sm-2 col-form-label text-right">Category</label>
          <div class="col-sm-10">
            <select class="form-control" id="auctionCategory" name="auctionCategory">
              
              <!-- here we need to select options from predefined categories-->
              <?php 
                  $conn = OpenConn();
                  echo "<option value='error' selected>Choose from options</option>";
                  // select all cateogories from category table 
                  $sql = "SELECT * FROM category";
                  $result = mysqli_query($conn,$sql);

                  // if values exist
                  if (mysqli_num_rows($result)) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                       // $category = mysqli_real_escape_string($conn,$row['category_name']);
                      echo "<option value=".$row['category_id'].">".$row['category_name']."</option>";
                    }
                  }
                  // each category name is send as a post variable if selected

              ?>

            </select>
            <small id="categoryHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> Select a category for this item.</small>
          </div>
        </div>

        <div class="form-group row">
          <label for="auctionStartPrice" class="col-sm-2 col-form-label text-right">Starting price</label>
          <div class="col-sm-10">
	        <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">£</span>
              </div>
              <input type="number" class="form-control" id="auctionStartPrice"  name="auctionStartPrice">
            </div>
            <small id="startBidHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> Initial bid amount.</small>
          </div>
        </div>

        <div class="form-group row">
          <label for="auctionReservePrice" class="col-sm-2 col-form-label text-right">Reserve price</label>
          <div class="col-sm-10">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">£</span>
              </div>
              <input type="number" class="form-control" id="auctionReservePrice" name="auctionReservePrice">
            </div>
            <small id="reservePriceHelp" class="form-text text-muted">Optional. Auctions that end below this price will not go through. This value is not displayed in the auction listing.</small>
          </div>
        </div>

        <div class="form-group row">
          <label for="auctionEndDate" class="col-sm-2 col-form-label text-right">End date</label>
          <div class="col-sm-10">
            <input type="datetime-local" class="form-control" id="auctionEndDate" name="auctionEndDate">
            <small id="endDateHelp" class="form-text text-muted"><span class="text-danger">* Required.</span> Day for the auction to end.</small>
          </div>
        </div>

        <button type="submit" class="btn btn-primary form-control">Create Auction</button>
      </form>
    </div>
  </div>
</div>

</div>


<?php include_once("footer.php")?>