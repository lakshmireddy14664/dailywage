<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("location:login.php");
    exit();
}

$uid = $_SESSION['user_id'];

$res = $conn->query("SELECT * FROM notifications WHERE user_id='$uid' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>

/* 🌌 Background */
body {
    margin: 0;
    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)),
    url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d') no-repeat center center/cover;
    font-family: 'Segoe UI', sans-serif;
}

/* Overlay */
.overlay {
    min-height: 100vh;
    padding: 30px 10px;
}

/* Card Container */
.main-card {
    max-width: 700px;
    margin: auto;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    color: white;
}

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Back Button */
.back-btn {
    color: white;
    font-size: 20px;
    text-decoration: none;
}

.back-btn:hover {
    color: #00c6ff;
}

/* Title */
h3 {
    text-align: center;
    margin-bottom: 20px;
}

/* Notification Card */
.notify-card {
    background: rgba(255,255,255,0.15);
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 12px;
    transition: 0.3s;
    border-left: 5px solid #00c6ff;
}

.notify-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.4);
}

/* Icon */
.icon {
    margin-right: 10px;
    color: #00c6ff;
}

/* Empty */
.empty {
    text-align: center;
    margin-top: 20px;
    color: #ccc;
}

/* Mobile */
@media(max-width:600px){
    .main-card{
        margin:10px;
    }
}

</style>

</head>

<body>

<div class="overlay">
<div class="main-card">

<div class="header">
<a href="dashboard.php" class="back-btn">
    <i class="fas fa-arrow-left"></i>
</a>
<h3><i class="fas fa-bell"></i> Notifications</h3>
</div>

<hr>

<?php
if($res->num_rows == 0){
    echo "<div class='empty'>🔔 No Notifications Yet</div>";
}

while($n = $res->fetch_assoc()){
    echo "<div class='notify-card'>";
    echo "<i class='fas fa-bell icon'></i>";
    echo $n['message'];
    echo "</div>";
}
?>

</div>
</div>

</body>
</html>