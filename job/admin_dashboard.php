<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin_id'])){
    header("location:admin_login.php");
    exit();
}
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
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)),
    url('https://images.unsplash.com/photo-1551288049-bebda4e38f71') no-repeat center center/cover;
}

/* Overlay */
.overlay {
    min-height: 100vh;
    padding: 30px 10px;
}

/* Main Card */
.main-card {
    max-width: 1200px;
    margin: auto;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 15px 50px rgba(0,0,0,0.6);
    color: white;
}

/* Header */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

h3 {
    font-weight: bold;
}

/* Logout */
.logout-btn {
    border-radius: 30px;
}

/* Stats Cards */
.stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px,1fr));
    gap: 15px;
    margin-top: 20px;
}

.stat-box {
    background: rgba(255,255,255,0.15);
    padding: 20px;
    border-radius: 15px;
    text-align: center;
    transition: 0.3s;
}

.stat-box:hover {
    transform: scale(1.05);
}

.stat-box i {
    font-size: 30px;
    margin-bottom: 10px;
}

/* Section */
.section-title {
    margin-top: 30px;
    font-size: 20px;
    font-weight: bold;
    border-left: 5px solid #00c6ff;
    padding-left: 10px;
}

/* Cards */
.custom-card {
    background: rgba(255,255,255,0.15);
    padding: 12px;
    border-radius: 10px;
    margin-top: 10px;
    transition: 0.3s;
}

.custom-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.5);
}

/* Delete */
.btn-sm {
    border-radius: 20px;
}

/* Responsive */
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

<!-- HEADER -->
<div class="header">
    <h3><i class="fas fa-chart-line"></i> Admin Dashboard</h3>
    <a href="logout.php?direct=1" class="btn btn-danger logout-btn">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

<hr>

<!-- 🔥 STATS -->
<div class="stats">

<?php
$totalUsers = $conn->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
$totalWorks = $conn->query("SELECT COUNT(*) as c FROM works")->fetch_assoc()['c'];
$totalApps = $conn->query("SELECT COUNT(*) as c FROM applications")->fetch_assoc()['c'];
?>

<div class="stat-box">
    <i class="fas fa-users"></i>
    <h4><?php echo $totalUsers; ?></h4>
    <p>Users</p>
</div>

<div class="stat-box">
    <i class="fas fa-briefcase"></i>
    <h4><?php echo $totalWorks; ?></h4>
    <p>Works</p>
</div>

<div class="stat-box">
    <i class="fas fa-file-alt"></i>
    <h4><?php echo $totalApps; ?></h4>
    <p>Applications</p>
</div>

</div>

<!-- USERS -->
<div class="section-title">👤 Users</div>

<?php
$users = $conn->query("SELECT * FROM users ORDER BY id DESC LIMIT 5");

while($u = $users->fetch_assoc()){
    echo "<div class='custom-card'>";
    echo "<i class='fas fa-user'></i> <b>".$u['name']."</b> (".$u['phone'].")";
    echo "<a href='admin_delete.php?type=user&id=".$u['id']."' class='btn btn-sm btn-danger float-end'>Delete</a>";
    echo "</div>";
}
?>

<!-- WORKS -->
<div class="section-title">💼 Works</div>

<?php
$works = $conn->query("SELECT * FROM works ORDER BY id DESC LIMIT 5");

while($w = $works->fetch_assoc()){
    echo "<div class='custom-card'>";
    echo "<i class='fas fa-briefcase'></i> <b>".$w['work_name']."</b> - ".$w['place'];
    echo "<a href='admin_delete.php?type=work&id=".$w['id']."' class='btn btn-sm btn-danger float-end'>Delete</a>";
    echo "</div>";
}
?>

<!-- APPLICATIONS -->
<div class="section-title">📋 Applications</div>

<?php
$app = $conn->query("
SELECT works.work_name, users.name 
FROM applications
JOIN works ON applications.work_id=works.id
JOIN users ON applications.user_id=users.id
ORDER BY applications.id DESC LIMIT 5
");

while($a = $app->fetch_assoc()){
    echo "<div class='custom-card'>";
    echo "👷 <b>".$a['name']."</b> applied for <b>".$a['work_name']."</b>";
    echo "</div>";
}
?>

</div>
</div>

</body>
</html>