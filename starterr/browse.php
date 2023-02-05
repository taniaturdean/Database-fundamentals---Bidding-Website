<?php include_once("header.php")?>
<?php include_once("database.php")?>
<?php include_once("session.php") ?>
<?php require("utilities.php")?>
<?php require_once("debug_to_console.php")?>

<div class="container">

<h2 class="my-3">Browse listings</h2>

<div id="searchSpecs">
<!-- When this form is submitted, this PHP page is what processes it.
     Search/sort specs are passed to this page through parameters in the URL
     (GET method of passing data to a page). 
  
    -->
  <?php 
    if (isset($_GET['error'])) {
      if ($_GET['error'] == 'emailnotexistant') {
        alert("Email does not exist");

      }
      elseif ($_GET['error'] == 'incorrectdetails'){
        alert("Incorrect details");
      }
    }
  
  
  ?>


<form method="get" action="browse.php">

  <div class="row">
    <div class="col-md-5 pr-0">
      <div class="form-group">
        <label for="keyword" class="sr-only">Search keyword:</label>
	    <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text bg-transparent pr-0 text-muted">
              <i class="fa fa-search"></i>
            </span>
          </div>
          <input type="text" class="form-control border-left-0" id="keyword" name="keyword" value="<?php if(isset($_GET['keyword'])){echo $_GET['keyword'];}?>" placeholder="Search for anything">
        </div>
      </div>
    </div>



    <div class="col-md-3 pr-0">
      <div class="form-group">
        <label for="cat" class="sr-only">Search within:</label>
        <select class="form-control" id="cat" name="cat">
          <!-- here we need to select options from predefined categories-->
            <?php 
                  $conn = OpenConn();
                  
                  // select all cateogories from category table 
                  $sql = "SELECT * FROM category";
                  $result = mysqli_query($conn,$sql);

                  // if values exist
                  if (mysqli_num_rows($result)) {
                    echo "<option value='error' selected>All</option>";
                    if (!isset($_GET['cat'])){
                      while($row = mysqli_fetch_assoc($result)) {
                       echo "<option value=".$row['category_id'].">".$row['category_name']."</option>";
                     }
                    }
                    else {
                      $cat_id = $_GET['cat'];

                      while($row = mysqli_fetch_assoc($result)) {
                       if ($row['category_id']==$cat_id) {
                        echo "<option value=".$row['category_id']." selected>".$row['category_name']."</option>";
                       }       
                       else {
                        echo "<option value=".$row['category_id'].">".$row['category_name']."</option>";
                       }
                      }

                    }

                  }

          ?>
        </select>
      </div>
    </div>
      
    
      <div class="col-md-3 pr-0">
      <div class="form-group">

        <select class="form-control" id="order_by" name="order_by"> 
          <?php

         
            if(isset($_GET['order_by'])){  
              
                $options = array(
                "pricelow" => "Start price (low to high)",
                "pricehigh" => "Start price (high to low)",
                "date" => "Soonest expiry",
                    );

              
              
                    echo "<option value=".$_GET['order_by'].">".$options[$_GET['order_by']]."</option>";
                    unset($options[$_GET['order_by']]);
                    foreach($options as $opt => $namee)
                            {
                          echo "<option value=".$opt.">".$namee."</option>";
                              }

              
            }
            else{
            ?>
          <option value="date">Soonest expiry</option>
          <option value="pricelow">Start price (low to high)</option>
          <option value="pricehigh">Start price (high to low)</option>
          

          <?php
            }

          ?>

          
        </select>
      </div>
    </div>

  
    
 

    <div class="col-md-1 px-0">
      <button type="submit" value="submit" class="btn btn-primary">Search</button>
    </div>

    <div class="col-md-3 pr-0">
    
    Include ended auctions <input type="checkbox"  name="checkbox_name" value="checkbox_value" <?php if(isset($_GET['checkbox_name'])){echo "checked='checked'" ;}?> >
  
    </div>
    
  </div>
</form>
</div> <!-- end search specs bar -->


</div>

<?php
  // Retrieve these from the URL

  if (!isset($_GET['keyword'])) {
    // TODO: Define behavior if a keyword has not been specified
    $keyword="";
    
  }
  else {
    $keyword = $_GET['keyword'];
  }

  if (!isset($_GET['cat'])) {
    // TODO: Define behavior if a category has not been specified.
    $category="error";
    
  }
  else {
    $category = $_GET['cat'];
  }
  
  if (!isset($_GET['order_by'])) {
    // TODO: Define behavior if an order_by value has not been specified.
    $ordering='';
  }
  else {
    $ordering = $_GET['order_by'];
  }
  
  if (!isset($_GET['page'])) {
    $curr_page = 1;
  }
  else {
    $curr_page = $_GET['page'];
  }

if(isset($_GET['checkbox_name'])){
  $check=1;
  
}
else{$check=0;}

  /* TODO: Use above values to construct a query. Use this query to 
     retrieve data from the database. (If there is no form data entered,
     decide on appropriate default value/default query to make. */

  
  
  /* For the purposes of pagination, it would also be helpful to know the
     total number of results that satisfy the above query */
  $num_results = 96; // TODO: Calculate me for real
  $results_per_page = 10;
  $max_page = ceil($num_results / $results_per_page);
?>

<div class="container mt-5">

<!-- TODO: If result set is empty, print an informative message. Otherwise... -->

<ul class="list-group">

<!-- TODO: Use a while loop to print a list item for each auction listing
     retrieved from the query -->

<?php
///
  $conn = openConn();
      
  
  if($ordering=="pricelow"){
    $ord=" ORDER BY startPrice ASC";}
  else if($ordering=="pricehigh"){
    $ord=" ORDER BY startPrice DESC";}
  else {
    $ord=" ORDER BY endDate ASC";}

    if($check==1){
      $ch="";
    }
    else{
      $ch=" WHERE enddate > CURRENT_TIMESTAMP";
      $ch1="and enddate > CURRENT_TIMESTAMP";
    }


// if no keyword and no category
  if ($keyword=="" and $category=="error"){
      $sql = "SELECT * FROM items".$ch;
    }
// if keyword and no category
  elseif($keyword<>"" and $category=="error" ){
    
      $sql =  "SELECT * FROM items WHERE itemName LIKE '%$keyword%'".$ch1;

}
  // if no keyword but category
  elseif($keyword=="" and $category<>"error"){
    
    $sql="SELECT * FROM items,category WHERE items.category_id=category.category_id and category.category_id=$category ".$ch1;
  }
  // if keyword and category
  elseif($keyword<>"" and $category<>"error"){
   
    $sql="SELECT * FROM items,category WHERE items.category_id=category.category_id and category.category_id=$category and itemName LIKE '%$keyword%' ".$ch1;
  }
  
  
  $sql=$sql.$ord;

  debug_to_console($sql);


  $result = mysqli_query($conn,$sql);
  debug_to_console($ord);
  $num_results = mysqli_num_rows($result); // TODO: Calculate me for real
  $results_per_page = 10;
  $max_page = ceil($num_results / $results_per_page);

  $row_ind = 0;
  $first_ind = ($curr_page - 1) * $results_per_page;
  $last_ind = min($num_results, $first_ind + $results_per_page) - 1;

  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      if ($row_ind > $last_ind){
        break;
      }
      if ($row_ind < $first_ind){
        $row_ind += 1;
        continue;
      }
      
      //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
      $item_id = $row['item_id'];
      $title = $row['itemName'];
      $desc = $row['description'];
      $end_time = $row['endDate'];
      $img_url = $row['image'];
      $startP=$row['startPrice'];

      // NEEDS TO CHANGE WHEN WE HAVE
      // both these variables need to be changed to highest of bids when bids features are added
      $sql1 = "SELECT MAX(bid_price) FROM bids WHERE item_id=$item_id";
      $result1 = mysqli_query($conn,$sql1) or exit(mysqli_error()); 
      $row = mysqli_fetch_array($result1);
      if ($row[0]==NULL) {
          $price = $startP;
          
      }
      else{
          $price = $row[0];
      }

      //$num_bids = 1; 
      $num_bids = bidNums($item_id);
      
      // This uses a function defined in utilities.php
      print_listing_li($item_id, $img_url, $title, $desc, $price, $num_bids, $end_time);
      $row_ind += 1;
    }
    
    closeConn($conn);
  }
  else{

    echo "<div> No listings to show yet! </div>";
    closeConn($conn);

  }

  // This uses a function defined in utilities.php
//////
?>

</ul>

<!-- Pagination for results listings -->
<nav aria-label="Search results pages" class="mt-5">
  <ul class="pagination justify-content-center">
  
<?php

  // Copy any currently-set GET variables to the URL.
  $querystring = "";
  foreach ($_GET as $key => $value) {
    if ($key != "page") {
      $querystring .= "$key=$value&amp;";
    }
  }
  
  $high_page_boost = max(3 - $curr_page, 0);
  $low_page_boost = max(2 - ($max_page - $curr_page), 0);
  $low_page = max(1, $curr_page - 2 - $low_page_boost);
  $high_page = min($max_page, $curr_page + 2 + $high_page_boost);
  
  if ($curr_page != 1) {
    echo('
    <li class="page-item">
      <a class="page-link" href="browse.php?' . $querystring . 'page=' . ($curr_page - 1) . '" aria-label="Previous">
        <span aria-hidden="true"><i class="fa fa-arrow-left"></i></span>
        <span class="sr-only">Previous</span>
      </a>
    </li>');
  }
    
  for ($i = $low_page; $i <= $high_page; $i++) {
    if ($i == $curr_page) {
      // Highlight the link
      echo('
    <li class="page-item active">');
    }
    else {
      // Non-highlighted link
      echo('
    <li class="page-item">');
    }
    
    // Do this in any case
    echo('
      <a class="page-link" href="browse.php?' . $querystring . 'page=' . $i . '">' . $i . '</a>
    </li>');
  }
  
  if ($curr_page != $max_page) {
    echo('
    <li class="page-item">
      <a class="page-link" href="browse.php?' . $querystring . 'page=' . ($curr_page + 1) . '" aria-label="Next">
        <span aria-hidden="true"><i class="fa fa-arrow-right"></i></span>
        <span class="sr-only">Next</span>
      </a>
    </li>');
  }
?>

  </ul>
</nav>


</div>



<?php include_once("footer.php")?>

