<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$uid = $_SESSION['user_id'];
$res = $conn->query("SELECT * FROM users WHERE id='$uid'");
$user = $res->fetch_assoc();

if(isset($_POST['update']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $photo = $user['photo'];

    if(!empty($_FILES['photo']['name'])){
        $photo = time().$_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/".$photo);
    }

    $conn->query("UPDATE users SET 
        name='$name',
        email='$email',
        phone='$phone',
        photo='$photo'
        WHERE id='$uid'
    ");

    echo "<script>alert('Profile Updated Successfully'); window.location='profile.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Profile</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

<style>

/* ===== BODY BACKGROUND ===== */
body {
    margin:0;
    padding:0;
    font-family: 'Poppins', sans-serif;
    height:100vh;
    background: url('https://images.unsplash.com/photo-1503264116251-35a269479413') no-repeat center center/cover;
}

/* ===== DARK OVERLAY ===== */
.overlay {
    height:100vh;
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.85));
    display:flex;
    justify-content:center;
    align-items:center;
}

/* ===== GLASS CARD ===== */
.glass-card {
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(20px);
    padding:35px;
    border-radius:20px;
    width:100%;
    max-width:380px;
    text-align:center;
    color:white;
    box-shadow:0 25px 70px rgba(0,0,0,0.7);
    animation: fadeIn 1s ease;
}

/* animation */
@keyframes fadeIn {
    from {opacity:0; transform:translateY(30px);}
    to {opacity:1; transform:translateY(0);}
}

/* ===== PROFILE IMAGE ===== */
.profile-img {
    width:120px;
    height:120px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #00c6ff;
    margin-bottom:10px;
    transition:0.4s;
}

.profile-img:hover {
    transform: scale(1.1);
    box-shadow:0 0 25px #00c6ff;
}

/* ===== INPUT ===== */
.form-control {
    background: rgba(255,255,255,0.15);
    border:none;
    color:white;
    margin-bottom:12px;
}

.form-control::placeholder {
    color:#ddd;
}

/* ===== BUTTON ===== */
.btn-update {
    background: linear-gradient(45deg,#00c6ff,#0072ff);
    border:none;
    padding:10px;
    border-radius:30px;
    color:white;
    transition:0.3s;
}

.btn-update:hover {
    transform: scale(1.05);
}

/* ===== FILE INPUT ===== */
input[type="file"]{
    background: rgba(255,255,255,0.1);
    color:white;
}

/* ===== RESPONSIVE ===== */
@media(max-width:500px){
    .glass-card{
        margin:15px;
        padding:25px;
    }
}

</style>
</head>

<body>

<div class="overlay">

<div class="glass-card">

<h3>Edit Profile</h3>

<form method="post" enctype="multipart/form-data">

<!-- IMAGE -->
<img src="uploads/<?php echo $user['photo']; ?>" id="preview" class="profile-img">

<input type="file" name="photo" id="file" class="form-control">

<!-- INPUTS -->
<input type="text" name="name" class="form-control"
value="<?php echo $user['name']; ?>" required>

<input type="email" name="email" class="form-control"
value="<?php echo $user['email']; ?>" required>

<input type="text" name="phone" class="form-control"
value="<?php echo $user['phone']; ?>" required>

<button name="update" class="btn btn-update w-100">Update Profile</button>

</form>

</div>

</div>

<!-- IMAGE PREVIEW SCRIPT -->
<script>
document.getElementById("file").onchange = function(e){
    const [file] = this.files;
    if(file){
        document.getElementById("preview").src = URL.createObjectURL(file);
    }
}
</script>

</body>
</html>