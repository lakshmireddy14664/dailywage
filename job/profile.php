<?php
session_start();
include 'db.php';

$uid=$_SESSION['user_id'];
$res=$conn->query("SELECT * FROM users WHERE id='$uid'");
$user=$res->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>My Profile</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

<style>
body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.85)),
                url('https://images.unsplash.com/photo-1492724441997-5dc865305da7') no-repeat center center/cover;
}

/* overlay */
.overlay {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* profile card */
.profile-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(18px);
    padding: 35px;
    border-radius: 20px;
    text-align: center;
    width: 100%;
    max-width: 370px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.7);
    color: white;
    animation: fadeIn 1s ease-in-out;
}

/* animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(25px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* profile image */
.profile-img {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid #00c6ff;
    margin-bottom: 12px;
    transition: 0.4s;
}

.profile-img:hover {
    transform: scale(1.08);
}

/* username */
.username {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 5px;
}

/* email small */
.email {
    font-size: 13px;
    opacity: 0.8;
    margin-bottom: 15px;
}

/* info box */
.info {
    font-size: 15px;
    margin: 8px 0;
    padding: 10px;
    border-radius: 10px;
    background: rgba(255,255,255,0.15);
}

/* buttons */
.btn-custom {
    margin-top: 12px;
    border-radius: 30px;
    padding: 10px 25px;
    font-weight: 500;
    border: none;
    transition: 0.3s;
}

/* back button */
.btn-back {
    background: linear-gradient(45deg, #00c6ff, #0072ff);
    color: white;
}

.btn-back:hover {
    transform: scale(1.05);
}

/* edit button */
.btn-edit {
    background: linear-gradient(45deg, #42e695, #3bb2b8);
    color: white;
}

.btn-edit:hover {
    transform: scale(1.05);
}

/* responsive */
@media(max-width:500px){
    .profile-card{
        margin:15px;
        padding:25px;
    }
}
</style>
</head>

<body>

<div class="overlay">
<div class="profile-card">

<h3>My Profile</h3>

<img src="uploads/<?php echo $user['photo']; ?>" class="profile-img">

<div class="username"><?php echo $user['name']; ?></div>
<div class="email"><?php echo $user['email']; ?></div>

<div class="info"><b>📞 Phone:</b> <?php echo $user['phone']; ?></div>

<!-- Buttons -->
<a href="dashboard.php" class="btn btn-custom btn-back">⬅ Back</a>
<a href="edit_profile.php" class="btn btn-custom btn-edit">✏ Edit</a>

</div>
</div>

</body>
</html>