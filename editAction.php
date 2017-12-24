<?php

    require_once("./customerFunction.php");
    session_start();
    $id = trim($_POST['id']);
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $submit =  trim($_POST['submit']);

    // setcookie("name", $name, time()+(60*5), "/");
    // setcookie("surname", $surname, time()+(60*5), "/");
    // setcookie("phone", $phone, time()+(60*5), "/");
    // setcookie("email", $email, time()+(60*5), "/");

    $_SESSION["name"] = $name;
    $_SESSION["surname"] = $surname;
    $_SESSION["phone"] = $phone;
    $_SESSION["email"] = $email;


    if (!isset($submit)) {
        header("location:insert.php");
    }

    if (($name)=='') {
        header("location:insert.php?return=1");
        exit;
    }
    if (($surname)=='') {
        header("location:insert.php?return=2");
        exit;
    }
    
    if (($phone)=='') {
        header("location:insert.php?return=3");
        exit;
    }
    
    if (($email)=='') {
        header("location:insert.php?return=4");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match('/@.+\./', $email)) {
        header("location:insert.php?return=5");
        exit;
    }

    updateCustomer($id, $name, $surname, $phone, $email);

    session_unset();
    session_destroy();