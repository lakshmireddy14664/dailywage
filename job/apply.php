<?php
session_start();
include 'db.php';

$uid = $_SESSION['user_id'];
$work_id = $_GET['id'];

// get work date
$work = $conn->query("SELECT work_date FROM works WHERE id='$work_id'");
$w = $work->fetch_assoc();
$date = $w['work_date'];

// check already applied
$check = $conn->query("
SELECT * FROM applications 
JOIN works ON applications.work_id = works.id
WHERE applications.user_id='$uid' AND works.work_date='$date'
");

if($check->num_rows > 0){
    echo "❌ Already applied for a job on this date";
}else{
    $conn->query("INSERT INTO applications(user_id,work_id) VALUES('$uid','$work_id')");
    echo "✅ Applied Successfully";
}
?>