<?php
session_start();
include 'db.php';

/*
🔑 KEY LOGIC:
if URL has ?direct=1 → skip feedback → logout directly
*/

// 🔴 ADMIN → always direct logout
if(isset($_SESSION['admin_id'])){
    session_destroy();
    header("location:login.php");
    exit();
}

// ❌ Not logged in
if(!isset($_SESSION['user_id'])){
    header("location:login.php");
    exit();
}

// 🔥 DIRECT LOGOUT (skip feedback)
if(isset($_GET['direct']) && $_GET['direct'] == 1){
    session_destroy();
    header("location:login.php");
    exit();
}

// 🟢 FINAL LOGOUT BUTTON
if(isset($_POST['final_logout'])){
    session_destroy();
    header("location:login.php");
    exit();
}

// 🟢 SAVE FEEDBACK
if(isset($_POST['submit_feedback'])){
    $uid = $_SESSION['user_id'];
    $rating = $_POST['rating'];
    $message = $_POST['message'];

    $conn->query("INSERT INTO feedback(user_id,rating,message) 
    VALUES('$uid','$rating','$message')");

    $feedback_done = true;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: url('https://images.unsplash.com/photo-1492724441997-5dc865305da7') no-repeat center center/cover;
    margin:0;
    font-family: Arial;
}

.overlay {
    background: rgba(0,0,0,0.7);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card {
    background:white;
    padding:25px;
    border-radius:15px;
    width:100%;
    max-width:400px;
    text-align:center;
}

.star {
    font-size:30px;
    cursor:pointer;
    color:#ccc;
}

.star.selected {
    color: gold;
}
</style>

<script>
function setRating(val){
    document.getElementById("rating").value = val;

    let stars = document.querySelectorAll(".star");
    stars.forEach((s,i)=>{
        if(i < val) s.classList.add("selected");
        else s.classList.remove("selected");
    });
}
</script>

</head>
<body>

<div class="overlay">
<div class="card">

<?php if(isset($feedback_done)){ ?>

<h4>✅ Feedback Submitted</h4>
<p>Click logout to exit</p>

<form method="POST">
    <button name="final_logout" class="btn btn-danger w-100">Logout</button>
</form>

<?php } else { ?>

<h4>⭐ Give Feedback</h4>

<form method="POST">
<input type="hidden" name="rating" id="rating" required>

<div class="mb-3">
<span class="star" onclick="setRating(1)">★</span>
<span class="star" onclick="setRating(2)">★</span>
<span class="star" onclick="setRating(3)">★</span>
<span class="star" onclick="setRating(4)">★</span>
<span class="star" onclick="setRating(5)">★</span>
</div>

<textarea name="message" class="form-control mb-3" placeholder="Write your feedback..." required></textarea>

<button name="submit_feedback" class="btn btn-success w-100 mb-2">Submit Feedback</button>
</form>

<form method="POST">
    <button name="final_logout" class="btn btn-secondary w-100">Skip & Logout</button>
</form>

<?php } ?>

</div>
</div>

</body>
</html>