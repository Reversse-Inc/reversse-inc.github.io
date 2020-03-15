<?php

session_start();

require_once 'config/db.php';
require_once 'emailController.php';

$errors = array();
$username = "";
$email = "";
$phone = "";
$firstname = "";
$lastname = "";

// if user clicks on the sign up button
if (isset($_POST['signup-btn'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $passwordConf = $_POST['passwordConf'];

    // validation
    if (empty($username)) {
        $errors['username'] = "Nom d'utilisateur requis";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Votre adresse est invalide.";
    }
    if (empty($email)) {
        $errors['email'] = "Email requis";
    }
    if (empty($password)) {
        $errors['password'] = "Mot de passe requis";
    }
    if ($password !== $passwordConf) {
        $errors['password'] = "Les deux mots de passe ne sont pas les m&ecirc;mes.";
    }

    $emailQuery = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = $conn->prepare($emailQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userCount = $result->num_rows;
    $stmt->close();

    if ($userCount > 0) {
        $errors['email'] = "Courriel d&eacute;j&agrave; existant.";
    }

    if (count($errors) === 0) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(50));
        $verified = false;

        $sql = "INSERT INTO users (username, email, firstname, lastname, verified, phone, token, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssbsss', $username, $email, $firstname, $lastname, $verified, $phone, $token, $password);
        
        if ($stmt->execute()) {
            // login user
            $user_id = $conn->insert_id;
            $_SESSION['id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['verified'] = $verified;

            sendVerificationEmail($email, $token);

            // set flash message
            $_SESSION['message'] = "Vous &ecirc;tes maintenant connect&eacute;";
            $_SESSION['alert-class'] = "alert-success";
            
            
// change the name below for the folder you want
$lowfirstname = strtolower($firstname);
$lowlastname = strtolower($lastname);

$dir = "users/' .$lowfirstname..$lowlastname..$id. '";

$file_to_write = 'index.php';
$fullname = "'.$firstname.' '.$lastname.'";

$content_to_write = "<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>'. $fullname .' - Profil Reveresse</title>
</head>
<body>
    <h1>Bonjour ' .$firstname. '</h1>    
</body>
</html>";

if( is_dir($dir) === false )
{
    mkdir($dir);
}

$file = fopen($dir . '/' . $file_to_write,"w");

// a different way to write content into
// fwrite($file,"Hello World.");

fwrite($file, $content_to_write);

// closes the file
fclose($file);

// this will show the created file from the created folder on screen
include $dir . '/' . $file_to_write;


            exit();
        }   else {
            $errors['db_error'] = "Erreur de base de données: échec de création de compte";
        }
            

    }

}


// if user clicks on the login button
if (isset($_POST['login-btn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // validation
    if (empty($username)) {
        $errors['username'] = "Nom d'utilisateur requis";
    }
    if (empty($password)) {
        $errors['password'] = "Mot de passe requis";
    }


    if (count($errors) === 0) {
        $sql = "SELECT * FROM users WHERE email=? OR username=? OR phone=? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $username, $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // login success
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['verified'] = $user['verified'];
        // set flash message
        $_SESSION['message'] = "Vous &ecirc;tes connect&eacute; avec succ&egrave;s";
        $_SESSION['alert-class'] = "alert-success";
        header('location: index.php');
        exit();

        } else {
        $errors['login_fail'] = "Nom d'utilisateur, courriel ou mot de passe erron&eacute;s";
        }
    }

}



// logout user
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['verified']);
    header('location: login');
    exit();
}

// verify user by token
function verifyUser($token) {
    global $conn;
    $sql = "SELECT * FROM users WHERE token='$token' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $update_query = "UPDATE users SET verified=1 WHERE token='$token'";

if (mysqli_query($conn, $update_query)) {
            // log user in
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['verified'] = 1;
            // set flash message
            $_SESSION['message'] = "Votre adresse courriel a &eacute;t&eacute; v&eacute;rifi&eacute; avec succ&egrave;s";
            $_SESSION['alert-class'] = "alert-success";
            header('location: ./');
            exit();
        }
    
    } else {
        echo 'Utilisateur non trouv&eacute;';
    }

}
?>
