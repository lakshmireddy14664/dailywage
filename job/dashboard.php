<?php 
session_start();
include 'db.php'; 

if(!isset($_SESSION['user_id'])){
    header("location:login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap + Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>

/* 🌌 BACKGROUND */
body {
    margin: 0;
    padding: 0;
    background:
        linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)),
        url('https://images.unsplash.com/photo-1492724441997-5dc865305da7') no-repeat center center/cover;
    font-family: 'Segoe UI', sans-serif;
}

/* MAIN CARD */
.main-card {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 25px;
    max-width: 1000px;
    margin: 30px auto;
    box-shadow: 0 15px 50px rgba(0,0,0,0.5);
    color: white;
}

/* JOB CARD */
.job-card {
    border-radius: 15px;
    padding: 15px;
    margin-top: 15px;
    background: rgba(255,255,255,0.15);
    transition: 0.3s;
}

.job-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
}

/* BUTTON */
.apply-btn {
    border-radius: 25px;
}

/* SEARCH */
.search-box input {
    border-radius: 25px;
    padding: 12px;
}

/* MOBILE */
@media(max-width:600px){
    .main-card{
        margin:10px;
    }
}

</style>
</head>

<body>

<!-- 🌐 NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
<div class="container">

<a class="navbar-brand fw-bold" href="dashboard.php">
    <i class="fas fa-briefcase"></i> Daily Wage
</a>

<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navMenu">

<ul class="navbar-nav me-auto">
<li class="nav-item">
<a class="nav-link" href="profile.php">👤 Profile</a>
</li>


<li class="nav-item">
<a class="nav-link active" href="index.php">🏠 Home</a>
</li>

<li class="nav-item">
<a class="nav-link" href="find_work.php">🔍 Find Work</a>
</li>

<li class="nav-item">
<a class="nav-link" href="add_work.php">➕ Post Work</a>
</li>

<li class="nav-item">
<a class="nav-link" href="my_jobs.php">📋 My Jobs</a>
</li>

<li class="nav-item">
<a class="nav-link" href="feedback.php">⭐ Ratings</a>
</li>

<li class="nav-item">
<a class="nav-link" href="notifications.php">🔔 Notifications</a>
</li>

</ul>

<ul class="navbar-nav">


<!-- 🚪 LOGOUT -->
<li class="nav-item">
<a class="nav-link text-danger fw-bold" href="logout.php">🚪 Logout</a>
</li>

</ul>

</div>
</div>
</nav>

<!-- MAIN -->
<div class="main-card">

<h3 class="text-center mb-3"><i class="fas fa-briefcase"></i> Dashboard</h3>

<!-- SEARCH -->
<form method="GET" class="search-box">
<input type="text" name="search" placeholder="🔍 Search by Work or Place"
class="form-control mb-3"
value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
</form>

<?php
$search = isset($_GET['search']) ? $_GET['search'] : '';

$res = $conn->query("SELECT works.*, users.phone 
FROM works 
JOIN users ON works.user_id = users.id 
WHERE work_name LIKE '%$search%' OR place LIKE '%$search%'");

if($res->num_rows == 0){
    echo "<div class='alert alert-warning text-center'>No jobs found</div>";
}

while($row = $res->fetch_assoc()){
    echo "<div class='job-card'>";
    
    echo "<h5><i class='fas fa-tools'></i> ".$row['work_name']."</h5>";
    
    echo "<p>
        📍 ".$row['place']." <br>
        💰 ₹".$row['wage']." <br>
        📅 ".$row['work_date']." <br>
        📞 ".$row['phone']."
    </p>";

    echo "<a href='apply.php?id=".$row['id']."' class='btn btn-primary apply-btn'>
            Apply
          </a>";

    echo "</div>";
}
?>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>