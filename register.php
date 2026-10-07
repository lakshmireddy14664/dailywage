<?php
session_start();
include 'db.php';

$msg = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // ❌ NAME VALIDATION
    if(!preg_match("/^[A-Za-z ]+$/", $name)){
        $msg = "<div class='alert alert-danger text-center'>
                ❌ Name should contain only letters (A-Z)
                </div>";
    }

    // ❌ PHONE MUST BE NUMERIC
    elseif(!preg_match("/^[0-9]+$/", $phone)){
        $msg = "<div class='alert alert-danger text-center'>
                ❌ Phone number should contain only numbers
                </div>";
    }

    // ❌ PHONE LENGTH
    elseif(strlen($phone) != 10){
        $msg = "<div class='alert alert-danger text-center'>
                ❌ Phone number must be exactly 10 digits
                </div>";
    }

    else {

        // 🔍 CHECK EMAIL
        $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $msg = "<div class='alert alert-warning text-center'>
                    ⚠️ Email already registered! <a href='login.php'>Login</a>
                    </div>";
        } 
        else {

            // 🔐 HASH PASSWORD
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // 📸 FILE UPLOAD
            $photo = $_FILES['photo']['name'];
            $tmp = $_FILES['photo']['tmp_name'];

            $allowed = ['jpg','jpeg','png'];
            $ext = strtolower(pathinfo($photo, PATHINFO_EXTENSION));

            if(!in_array($ext, $allowed)){
                $msg = "<div class='alert alert-danger text-center'>
                        ❌ Only JPG, JPEG, PNG files allowed
                        </div>";
            } else {

                $newname = time()."_".$photo;
                move_uploaded_file($tmp, "uploads/".$newname);

                // 🟢 INSERT
                $stmt = $conn->prepare("INSERT INTO users(name,phone,email,password,photo,role) VALUES(?,?,?,?,?,?)");
                $role = "user";
                $stmt->bind_param("ssssss", $name, $phone, $email, $hashed_password, $newname, $role);

                if($stmt->execute()){
                    $msg = "<div class='alert alert-success text-center'>
                            ✅ Registered Successfully! <a href='login.php'>Login</a>
                            </div>";
                } else {
                    $msg = "<div class='alert alert-danger text-center'>
                            ❌ Something went wrong!
                            </div>";
                }
            }
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
body {
    margin: 0;
    height: 100vh;
    background:
        linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)),
        url('https://images.unsplash.com/photo-1492724441997-5dc865305da7') no-repeat center/cover;
    font-family: 'Segoe UI';
}

.overlay {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
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
    border: none;
    color: white;
    font-weight: bold;
}

.bottom-text {
    text-align: center;
    margin-top: 15px;
}

.bottom-text a {
    color: #00c6ff;
}
</style>

<script>
// 🔥 LIVE RESTRICTION
function onlyLetters(e) {
    let char = String.fromCharCode(e.which);
    if (!/[A-Za-z ]/.test(char)) return false;
}

function onlyNumbers(e) {
    let char = String.fromCharCode(e.which);
    if (!/[0-9]/.test(char)) return false;
}
</script>

</head>

<body>

<div class="overlay">
<div class="card">

<h3 class="text-center"><i class="fas fa-user-plus"></i> Register</h3>

<!-- MESSAGE -->
<?php echo $msg; ?>

<form method="POST" enctype="multipart/form-data">

<input type="text" name="name" placeholder="👤 Enter Name"
class="form-control mb-3"
onkeypress="return onlyLetters(event)"
required>

<input type="text" name="phone" placeholder="📞 Enter Phone"
class="form-control mb-3"
onkeypress="return onlyNumbers(event)"
maxlength="10"
required>

<input type="email" name="email" placeholder="📧 Enter Email"
class="form-control mb-3" required>

<input type="password" name="password" placeholder="🔒 Enter Password"
class="form-control mb-3" required>

<label>📸 Upload Photo</label>
<input type="file" name="photo" class="form-control mb-3" required>

<button class="btn btn-custom">Register</button>

</form>

<div class="bottom-text">
    Already have an account? <a href="login.php">Login</a>
</div>

</div>
</div>

</body>
</html>