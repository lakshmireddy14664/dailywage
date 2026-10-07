<?php
session_start();
include 'db.php';

$msg = ""; // message variable

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 🔍 CHECK EMAIL EXISTS
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");

    if($check->num_rows > 0){
        // ❌ ALREADY REGISTERED
        $msg = "<div class='alert alert-warning text-center'>
                Already Registered! <a href='login.php'>Login Here</a>
                </div>";
    } else {

        // 📸 FILE UPLOAD
        $photo = $_FILES['photo']['name'];
        $tmp = $_FILES['photo']['tmp_name'];

        $folder = "uploads/".$photo;
        move_uploaded_file($tmp, $folder);

        // 🟢 INSERT
        $conn->query("INSERT INTO users(name,phone,email,password,photo,role)
        VALUES('$name','$phone','$email','$password','$photo','user')");

        // ✅ SUCCESS MESSAGE
        $msg = "<div class='alert alert-success text-center'>
                Registered Successfully! <a href='login.php'>Go to Login</a>
                </div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
body {
    margin: 0;
    padding: 0;
    height: 100vh;
    background:
        linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)),
        url('https://images.unsplash.com/photo-1492724441997-5dc865305da7') no-repeat center center/cover;
    font-family: 'Segoe UI', sans-serif;
}

.overlay {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card {
    width: 100%;
    max-width: 420px;
    padding: 30px;
    border-radius: 20px;
    backdrop-filter: blur(15px);
    background: rgba(255,255,255,0.1);
    box-shadow: 0 15px 50px rgba(0,0,0,0.5);
    color: white;
}

h3 {
    text-align: center;
    margin-bottom: 20px;
}

.form-control {
    border-radius: 12px;
    padding: 12px;
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
}

.form-control::placeholder {
    color: #ddd;
}

.btn-custom {
    width: 100%;
    padding: 12px;
    border-radius: 30px;
    background: linear-gradient(to right,#00c6ff,#0072ff);
    color: white;
    font-weight: bold;
    border: none;
}

/* bottom text */
.bottom-text {
    text-align: center;
    margin-top: 15px;
}

.bottom-text a {
    color: #00c6ff;
    text-decoration: none;
    font-weight: bold;
}

</style>
</head>

<body>

<div class="overlay">
<div class="card">

<h3><i class="fas fa-user-plus"></i> Register</h3>

<!-- ✅ MESSAGE SHOW -->
<?php echo $msg; ?>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="name" placeholder="👤 Enter Name" class="form-control mb-3" required>

<input type="text" name="phone" placeholder="📞 Enter Phone" class="form-control mb-3" required>

<input type="email" name="email" placeholder="📧 Enter Email" class="form-control mb-3" required>

<input type="password" name="password" placeholder="🔒 Enter Password" class="form-control mb-3" required>

<label><b>📸 Upload Photo</b></label>
<input type="file" name="photo" class="form-control mb-3" required>

<button class="btn btn-custom">Register</button>

</form>

<!-- 🔽 LOGIN LINK -->
<div class="bottom-text">
    Already have an account? 
    <a href="login.php">Login</a>
</div>

</div>
</div>

</body>
</html>