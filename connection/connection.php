<?php
session_start();

require_once './config/__config__.php';

try {
    // setup connection
    $conn = new PDO("mysql:host=" . SERVER . ";dbname=" . DATABASE, USER, PASS);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Connected successfully"; // print on successful connection
} catch (PDOException $e) {
    $_SESSION['error'] = $e->getMessage();
    header('location: error.php');
}
