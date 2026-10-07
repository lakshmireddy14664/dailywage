<?php 
session_start();
include 'db.php';

// 🔐 Generate CAPTCHA only once
if(empty($_SESSION['captcha'])){
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
    $_SESSION['captcha'] = substr(str_shuffle($chars), 0, 6);
}

$error = "";

// LOGIN LOGIC
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $role = $_POST['role'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $captcha = trim($_POST['captcha']);

    // CAPTCHA CHECK
    if($captcha !== $_SESSION['captcha']){
        $error = "Invalid Captcha";

        // regenerate captcha
        $_SESSION['captcha'] = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789'), 0, 6);

    } else {

        // CHECK USER
        $res = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$pass'");

        if($res->num_rows > 0){
            $row = $res->fetch_assoc();

            // USER LOGIN
            if($role == 'user' && $row['role'] == 'user'){
                $_SESSION['user_id'] = $row['id'];
                unset($_SESSION['captcha']);
                header("location:dashboard.php");
                exit();
            }

            // ADMIN LOGIN
            else if($role == 'admin' && $row['role'] == 'admin'){
                $_SESSION['admin_id'] = $row['id'];
                unset($_SESSION['captcha']);
                header("location:admin_dashboard.php");
                exit();
            }

            else{
                $error = "Wrong Role Selected";
            }

        } else {
            $error = "Invalid Email or Password";
        }
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

/* 🌌 BACKGROUND */
body {
    margin: 0;
    padding: 0;
    height: 100vh;
    background: 
        linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)),
        url('https://images.unsplash.com/photo-1521791136064-7986c2920216') no-repeat center center/cover;
    font-family: 'Segoe UI', sans-serif;
}

/* CENTER */
.overlay {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* CARD */
.card {
    position: relative;
    width: 100%;
    max-width: 400px;
    padding: 30px;
    border-radius: 20px;
    backdrop-filter: blur(20px);
    background: rgba(255,255,255,0.1);
    box-shadow: 0 15px 50px rgba(0,0,0,0.6);
    color: white;
}

/* BACK BUTTON */
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

/* TITLE */
h3 {
    text-align: center;
    margin-bottom: 25px;
    font-weight: bold;
}

/* INPUTS */
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

/* BUTTON */
.btn-custom {
    width: 100%;
    padding: 12px;
    border-radius: 30px;
    background: linear-gradient(to right,#ff416c,#ff4b2b);
    color: white;
    font-weight: bold;
    border: none;
}

.btn-custom:hover {
    transform: scale(1.05);
}

/* CAPTCHA */
.captcha-box {
    font-size: 22px;
    font-weight: bold;
    letter-spacing: 4px;
    background: rgba(255,255,255,0.2);
    padding: 12px;
    text-align: center;
    border-radius: 10px;
}

/* REFRESH */
.refresh-btn {
    width: 100%;
    margin-top: 8px;
    border-radius: 20px;
}

/* ERROR */
.error {
    text-align: center;
    margin-top: 10px;
    color: #ff6b6b;
}

</style>
</head>

<body>

<div class="overlay">
<div class="card">

<!-- BACK -->
<a href="register.php" class="back-btn">
    <i class="fas fa-arrow-left"></i>
</a>

<h3><i class="fas fa-user-lock"></i> Login</h3>

<form method="POST">

<select name="role" class="form-control mb-3" required>
    <option value="">Select Login Type</option>
    <option value="user">👤 User Login</option>
    <option value="admin">🛠 Admin Login</option>
</select>

<input type="email" name="email" placeholder="📧 Enter Email" class="form-control mb-3" required>

<input type="password" name="password" placeholder="🔒 Enter Password" class="form-control mb-3" required>

<!-- CAPTCHA -->
<div class="captcha-box">
    <?php echo $_SESSION['captcha']; ?>
</div>

<button type="button" onclick="location.reload()" class="btn btn-secondary refresh-btn">
    🔄 Refresh Captcha
</button>

<input type="text" name="captcha" placeholder="🔐 Enter Captcha" class="form-control mt-3 mb-3" required>

<button class="btn btn-custom">Login</button>

</form>

<!-- ERROR MESSAGE -->
<?php if($error){ ?>
<div class="error"><?php echo $error; ?></div>
<?php } ?>

</div>
</div>

</body>
</html>