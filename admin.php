<?php
session_start();
include 'db.php';

// check login
if(!isset($_SESSION['user_id'])){
    header("location:login.php");
}

// check admin role
$uid = $_SESSION['user_id'];
$res = $conn->query("SELECT * FROM users WHERE id='$uid'");
$user = $res->fetch_assoc();

if($user['role'] != 'admin'){
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    margin: 0;
    padding: 0;
    background: url('https://images.unsplash.com/photo-1492724441997-5dc865305da7') no-repeat center center/cover;
    font-family: Arial, sans-serif;
}

/* overlay */
.overlay {
    background: rgba(0,0,0,0.75);
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* card */
.denied-card {
    background: white;
    padding: 35px;
    border-radius: 15px;
    text-align: center;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.4);
}

/* title */
.title {
    font-size: 24px;
    font-weight: bold;
    color: red;
}

/* message */
.msg {
    margin-top: 10px;
    color: #555;
}

/* button */
.btn-back {
    margin-top: 20px;
    border-radius: 25px;
    padding: 10px 20px;
}
</style>
</head>

<body>

<div class="overlay">
<div class="denied-card">

<div class="title">🚫 Access Denied</div>
<div class="msg">You are not authorized to view this page.</div>

<a href="dashboard.php" class="btn btn-danger btn-back">⬅ Back to Dashboard</a>

</div>
</div>

</body>
</html>
<?php
exit();
}
?>