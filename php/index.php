<!DOCTYPE html>
<?php
// this is a sign up page for the website
session_start();
include('functions.php')
?>

<html lang = 'en'>
    <head>
        <title>
            Welcome new user!
        </title>
    </head>
    <body>
    <?php
    if( isset($_SESSION['status']) && $_SESSION['status'] === 'error') :
        $errors = $_SESSION['errors'];
    ?>
      <ul class = 'errors'>
            <?php foreach($errors as $e) : ?>
            <li><?= $e ?></li>
            <?php endforeach;?>
        </ul>
    <?php elseif (isset($_SESSION['status']) && $_SESSION['status'] ==='success') :
        $data = $_SESSION['data'];
    ?>
    <div class = 'success'>
        <p>Message sent successfully</p>
        <p>Here's your data:</p>
        <ul>
            <li>Username: <em><?=esc_str($data['username'])?></em></li>
            <li>First Name: <em><?=esc_str($data['firstname'])?></em></li>
            <li>Last Name: <em><?=esc_str($data['lastname'])?></em></li>
            <li>Password: <em><?=esc_str($data['password'])?></em></li>
            <li>Email: <em><?=esc_str($data['email'])?></em></li>
            <li>Gender: <em><?=esc_str($data['gender'])?></em></li>
            <li>Interests: <em><?=esc_str($data['interests'])?></em></li>
        </ul>
    </div>
    <?php endif;?>




    <p>please enter your details here:</p>
    <form action="handle-form.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Enter username">

            <label for="firstname">First Name:</label>
            <input type="text" name="firstname" id="firstname" placeholder="Enter firstname">

            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" id="lastname" placeholder="Enter lastname">

            <label for="password">Password:</label>
            <input type="text" name="password" id="password" placeholder="Enter password">

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Enter email">

            <label for="gender">Gender:</label>
            <select name="gender" id="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <p>Interests:</p>
            <input type="checkbox" name="interests[]" id="books" value="books">
            <label for="books">Books</label>
            <input type="checkbox" name="interests[]" id="clothes" value="clothes">
            <label for="clothes">Clothes</label>
            <input type="checkbox" name="interests[]" id="electronics" value="electronics">
            <label for="electronics">Electronics</label>
            <input type="checkbox" name="interests[]" id="gaming" value="gaming">
            <label for="gaming">Gaming</label>
            <input type="checkbox" name="interests[]" id="jewellery" value="jewellery">
            <label for="jewellery">Jewellery</label>
            <input type="checkbox" name="interests[]" id="pet_supplies" value="pet_supplies">
            <label for="pet_supplies">Pet Supplies</label>
            <input type="checkbox" name="interests[]" id="shoes" value="shoes">
            <label for="shoes">Shoes</label>


            <input type="submit" name="submit" value="Submit">
        </form>

    </body>
</html>
<?php
unset($_SESSION['status']);
unset($_SESSION['errors']);
unset($_SESSION['data']);