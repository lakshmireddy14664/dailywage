<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("location:login.php");
    exit();
}

if(isset($_POST['submit'])){
    $uid = $_SESSION['user_id'];
    $rating = $_POST['rating'];
    $msg = $_POST['message'];

    $conn->query("INSERT INTO feedback(user_id,rating,message)
    VALUES('$uid','$rating','$msg')");

    $success = "✅ Feedback Submitted Successfully!";
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
    height: 100vh;
    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)),
    url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f') no-repeat center center/cover;
    font-family: 'Segoe UI', sans-serif;
}

/* Center */
.overlay {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Card */
.card {
    position: relative; /* 🔥 needed */
    width: 100%;
    max-width: 420px;
    padding: 30px;
    border-radius: 20px;
    backdrop-filter: blur(15px);
    background: rgba(255,255,255,0.1);
    box-shadow: 0 10px 40px rgba(0,0,0,0.6);
    color: white;
}

/* 🔙 BACK BUTTON */
.back-btn {
    position: absolute;
    top: 15px;
    left: 15px;
    font-size: 22px;
    color: white;
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

/* Stars */
.star {
    font-size: 35px;
    cursor: pointer;
    color: #ccc;
}

.star.active {
    color: gold;
}

/* Textarea */
textarea {
    border-radius: 10px;
    padding: 10px;
    background: rgba(255,255,255,0.2);
    color: white;
    border: none;
}

textarea::placeholder {
    color: #ddd;
}

/* Button */
.btn-custom {
    width: 100%;
    border-radius: 25px;
    background: linear-gradient(to right,#00c6ff,#0072ff);
    color: white;
    font-weight: bold;
}

/* Success */
.success {
    text-align: center;
    color: #00ffcc;
    margin-bottom: 10px;
}

</style>

<script>
function setRating(val){
    document.getElementById("rating").value = val;

    let stars = document.querySelectorAll(".star");
    stars.forEach((s,i)=>{
        if(i < val){
            s.classList.add("active");
        } else {
            s.classList.remove("active");
        }
    });
}
</script>

</head>

<body>

<div class="overlay">
<div class="card">

<!-- 🔙 BACK TO DASHBOARD -->
<a href="dashboard.php" class="back-btn">
    <i class="fas fa-arrow-left"></i>
</a>

<h3><i class="fas fa-star"></i> Give Feedback</h3>

<?php if(isset($success)){ ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>

<form method="POST">

<input type="hidden" name="rating" id="rating" required>

<div class="text-center mb-3">
    <span class="star" onclick="setRating(1)">★</span>
    <span class="star" onclick="setRating(2)">★</span>
    <span class="star" onclick="setRating(3)">★</span>
    <span class="star" onclick="setRating(4)">★</span>
    <span class="star" onclick="setRating(5)">★</span>
</div>

<textarea name="message" class="form-control mb-3" placeholder="Write your feedback..." required></textarea>

<button name="submit" class="btn btn-custom">Submit Feedback</button>

</form>

</div>
</div>

</body>
</html>