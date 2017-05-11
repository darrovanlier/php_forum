<?php

include('dbconn.php');

$signup_message = null;
$username_used = null;
$email_used = null;

if (isset($_POST['signup'])) {
    $username = htmlentities($_POST['username']);
    $email = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);
    $user = true;

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
            $username_used = '<p class="text-danger">That username is taken</p>';
        } elseif ($check_email->rowCount() > 0) {
            $email_used = '<p class="text-danger">Sorry, that email is taken. Try another?</p>';
        } else {
            $createacc = $dbh->prepare('insert into users (username, email, password, user) values (:username, :email, :password, :user)');
            $createacc->execute([
                ':username' => preg_replace('/\s+/', '', $username),
                ':email' => $email,
                ':password' => hash('sha512', $password),
                ':user' => $user
            ]);
            $signup_message = '<div class="alert alert-success" role="alert">Your account has been created, <a href="login.php">login</a>.</div>';
        }
    }

}