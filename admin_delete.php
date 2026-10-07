<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin_id'])){
    header("location:admin_login.php");
}

$type=$_GET['type'];
$id=$_GET['id'];

if($type=="user"){
    $conn->query("DELETE FROM users WHERE id='$id'");
}
if($type=="work"){
    $conn->query("DELETE FROM works WHERE id='$id'");
}

header("location:admin_dashboard.php");
?>