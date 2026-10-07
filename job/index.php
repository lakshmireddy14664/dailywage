<?php
include 'db.php';

$msg = "";

if(isset($_POST['send']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $conn->query("INSERT INTO contact (name,email,message) VALUES ('$name','$email','$message')");
    $msg = "Message Sent Successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Daily Wage Connect</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>

body{
    margin:0;
    font-family:'Poppins',sans-serif;
    color:white;
}

/* NAVBAR */
.custom-navbar{
    background:
    linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)),
    url('https://images.unsplash.com/photo-1492724441997-5dc865305da7');
    background-size:cover;
}

/* HERO */
.hero{
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;

    background:
    linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.8)),
    url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c');

    background-size:cover;
    background-position:center;
    background-attachment:fixed;
}

/* TEXT */
.hero h1{
    font-size:55px;
    font-weight:bold;
}

.hero p{
    font-size:18px;
}

/* 🔥 WHITE BUTTON */
.btn-main{
    background:#ffffff;
    color:#000;
    border:none;
    padding:12px 35px;
    border-radius:30px;
    font-weight:500;
    transition:0.3s;
}

.btn-main:hover{
    background:#f1f1f1;
    transform:scale(1.05);
}

/* SECTIONS */
section{
    padding:90px 0;
}

/* ABOUT */
.about-section{
    background:
    linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)),
    url('https://images.unsplash.com/photo-1503387762-592deb58ef4e');
    background-size:cover;
}

/* FEATURES */
.features-section{
    background:
    linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)),
    url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7');
    background-size:cover;
}

/* CONTACT */
.contact-section{
    background:
    linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.8)),
    url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d');
    background-size:cover;
}

/* CARD */
.card-box{
    background:rgba(255,255,255,0.1);
    padding:25px;
    border-radius:20px;
    transition:0.3s;
}

.card-box:hover{
    transform:translateY(-10px);
}

/* FORM */
.form-control{
    background:rgba(255,255,255,0.1);
    border:none;
    color:white;
}

.msg{
    text-align:center;
    color:lightgreen;
}

</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
<div class="container">

<a class="navbar-brand fw-bold" href="#">💼 Daily Wage</a>

<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="nav">
<ul class="navbar-nav ms-auto">

<li class="nav-item"><a class="nav-link" href="#home">🏠 Home</a></li>
<li class="nav-item"><a class="nav-link" href="#about">ℹ About</a></li>
<li class="nav-item"><a class="nav-link" href="#features">⚙ Features</a></li>
<li class="nav-item"><a class="nav-link" href="#contact">📞 Contact</a></li>
<li class="nav-item"><a class="nav-link text-success" href="login.php">Login</a></li>

</ul>
</div>

</div>
</nav>

<!-- HERO -->
<section id="home" class="hero">
<div>
<h1>Daily Wage Connect</h1>
<p>Connecting Workers with Daily Job Opportunities</p>
<a href="register.php" class="btn btn-main mt-3">Get Started</a>
</div>
</section>

<!-- ABOUT -->
<section id="about" class="about-section text-center">
<div class="container">
<h2>About Platform</h2>
<p>Helping workers find jobs and employers hire easily.</p>
</div>
</section>

<!-- FEATURES -->
<section id="features" class="features-section text-center">
<div class="container">

<h2 class="mb-5">Features</h2>

<div class="row g-4">

<div class="col-md-4">
<div class="card-box">
<i class="fas fa-search fa-2x mb-3"></i>
<h5>Easy Search</h5>
</div>
</div>

<div class="col-md-4">
<div class="card-box">
<i class="fas fa-briefcase fa-2x mb-3"></i>
<h5>Post Jobs</h5>
</div>
</div>

<div class="col-md-4">
<div class="card-box">
<i class="fas fa-star fa-2x mb-3"></i>
<h5>Ratings</h5>
</div>
</div>

</div>

</div>
</section>

<!-- CONTACT -->
<section id="contact" class="contact-section">
<div class="container">

<h2 class="text-center mb-4">Contact Us</h2>

<?php if($msg!=""){ echo "<div class='msg'>$msg</div>"; } ?>

<div class="row justify-content-center">
<div class="col-md-6">

<form method="POST" class="p-4 bg-dark rounded">

<input type="text" name="name" class="form-control mb-3" placeholder="Your Name" required>
<input type="email" name="email" class="form-control mb-3" placeholder="Your Email" required>
<textarea name="message" class="form-control mb-3" placeholder="Message" required></textarea>

<button name="send" class="btn btn-main w-100">Send Message</button>

</form>

</div>
</div>

</div>
</section>

<!-- FOOTER -->
<footer class="text-center p-3 bg-dark">
<p>© 2026 Daily Wage Connect</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>