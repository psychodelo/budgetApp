<?php

session_start();
require_once 'dbbudget.php';

// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    // Could not get the data that should have been sent.
    die ('Please complete the registration form!');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
    // One or more values are empty.
    die ('Please complete the registration form');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo '<script type="text/javascript">;
            function danger(){
                       window.location.href = "registration.php";
                        }
                        </script>';

}

if (preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0) {
    echo '<script type="text/javascript">;       
                        window.location.href = "registration.php"; 
                        </script>';

}

if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
    echo '<script type="text/javascript">;                           
                        window.location.href = "registration.php";                       
                        </script>';
}

$password = md5($_POST['password']);
$green = 'class="text-success"';
// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id_user, password FROM accounts WHERE username = ?')) {


    // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
    // Store the result so we can check if the account exists in the database.
    if ($stmt->num_rows > 0) {
        // Username already exists
        echo '<script type="text/javascript">;
                        window.location.href = "registration.php";                     
                        }
                        </script>';

    } else {
        // Username doesnt exists, insert new account
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
            // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
//            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
            $stmt->execute();
            echo '<script type="text/javascript">;       
                        window.location.href = "login.php";
                        </script>';
        } else {
            // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
            echo '<script type="text/javascript">;       
                        window.location.href = "registration.php";
                        </script>';
        }
    }
    $stmt->close();
} else {
    // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
    echo '<script type="text/javascript">;       
                        window.location.href = "registration.php";
                        </script>';
}
$con->close();
?>
