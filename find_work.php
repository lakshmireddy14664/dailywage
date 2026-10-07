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
        url('https://images.unsplash.com/photo-1503387762-592deb58ef4e') no-repeat center center/cover;
    font-family: 'Segoe UI', sans-serif;
}

/* CENTER CONTAINER */
.container-box {
    max-width: 900px;
    margin: 40px auto;
    padding: 25px;
    border-radius: 20px;
    backdrop-filter: blur(15px);
    background: rgba(255,255,255,0.1);
    box-shadow: 0 15px 50px rgba(0,0,0,0.5);
    color: white;
}

/* TITLE */
h3 {
    text-align: center;
    margin-bottom: 20px;
}

/* SEARCH BOX */
.search-box input {
    border-radius: 25px;
    padding: 12px;
    border: none;
}

/* JOB CARD */
.job-card {
    background: rgba(255,255,255,0.15);
    border-radius: 15px;
    padding: 15px;
    margin-top: 15px;
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

/* BACK BUTTON */
.back-btn {
    text-decoration: none;
    color: white;
    font-size: 20px;
}

/* MOBILE */
@media(max-width:600px){
    .container-box{
        margin:10px;
    }
}

</style>
</head>

<body>

<div class="container-box">

<!-- 🔙 BACK -->
<a href="dashboard.php" class="back-btn">
    <i class="fas fa-arrow-left"></i> Back
</a>

<h3><i class="fas fa-search"></i> Find Work</h3>

<!-- 🔍 SEARCH -->
<form method="GET" class="search-box">
<input type="text" name="search" 
placeholder="🔍 Search by Work or Place"
class="form-control mb-3"
value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

<button class="btn btn-primary w-100">
    <i class="fas fa-search"></i> Search
</button>
</form>

<?php
$search = isset($_GET['search']) ? $_GET['search'] : '';

$res = $conn->query("SELECT * FROM works 
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
        📅 ".$row['work_date']."
    </p>";

    echo "<a href='apply.php?id=".$row['id']."' class='btn btn-success apply-btn'>
            Apply
          </a>";

    echo "</div>";
}
?>

</div>

</body>
</html>