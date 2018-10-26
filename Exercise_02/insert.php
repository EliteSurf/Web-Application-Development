<?php

require 'database.php';

if (!empty($_POST)) {
    // keep track validation errors
    $firstnameError = null;
    $lastnameError = null;
    $genderError = null;
    $citizenError = null;
    $mobilenoError = null;
    $homenoError = null;
    $dateError = null;
    $timeError = null;
    $emailError = null;
    
    // keep track post values
    
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $citizen = $_POST['citizen'];
    $mobileno = $_POST['mobileno'];
    $homeno = $_POST['homeno'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $email = $_POST['email'];
    //$message = $_POST['message'];
    
    // validate input
    $valid = true;
    if (empty($firstname)) {
        $nameError = 'Please enter First Name';
        $valid = false;
    }
    
    if (empty($lastname)) {
        $nameError = 'Please enter Last Name';
        $valid = false;
    }
    
    if (empty($gender)) {
        $nameError = 'Please select gender';
        $valid = false;
    }
    
    if (empty($citizen)) {
        $nameError = 'Please select citizenship';
        $valid = false;
    }
    
    if (empty($mobileno)) {
        $nameError = 'Please enter mobile number';
        $valid = false;
    }
    
    if (empty($homeno)) {
        $nameError = 'Please enter phone number(home)';
        $valid = false;
    }
    
    if (empty($date)) {
        $nameError = 'Please select date';
        $valid = false;
    }
    
    if (empty($time)) {
        $nameError = 'Please select time';
        $valid = false;
    }
    
    if (empty($email)) {
        $emailError = 'Please enter Email Address';
        $valid = false;
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $emailError = 'Please enter a valid Email Address';
        $valid = false;
    }
    
    // insert data
    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO customers (firstname, lastname, gender, citizen, mobileno, homeno, date, time, email) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($firstname, $lastname, $gender, $citizen, $mobileno, $homeno, $date, $time, $email));
        Database::disconnect();
        header("Location: index.html");
    }
}

?>