<?php

include('dbconn.php');

$signup_message = null;
$username_used = null;
$email_used = null;
$email_not_valid_msg = null;

if (isset($_POST['signup'])) {
    $username = htmlentities(str_replace(' ', '', ($_POST['username'])));
    $email = htmlentities(str_replace(' ', '', ($_POST['email'])));
    $password = htmlentities(str_replace(' ', '', ($_POST['password'])));

    if (!$username || !$email || !$password) {
        $signup_message = '<div class="alert alert-danger">Please fill in all fields.</div>';
    } else {
        $check_username = $dbh->prepare('select * from users where username = :username');
        $check_username->execute([
            ':username' => $username
        ]);
        $check_email = $dbh->prepare('select * from users where email = :email');
        $check_email->execute([
            ':email' => $email
        ]);
        if ($check_username->rowCount() > 0) {
            $username_used = '<p class="text-danger">Username is already in use.</p>';
        } elseif ($check_email->rowCount() > 0) {
            $email_used = '<p class="text-danger">Email is already in use</p>';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_not_valid_msg = '<p class="text-danger">Email is not valid</p>';
        } else {
            $createacc = $dbh->prepare('insert into users (username, email, password) values (:username, :email, :password)');
            $createacc->execute([
                ':username' => preg_replace('/\s+/', '', $username),
                ':email' => $email,
                ':password' => hash('sha512', $password)
            ]);
            $signup_message = '<div class="alert alert-success">Your account has been created. <a href="login.php">login</a>.</div>';
        }
    }
}

