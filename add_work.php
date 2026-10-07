<?php 
session_start();
include 'db.php'; 

$msg = "";
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    margin: 0;
    padding: 0;
    background: url('https://images.unsplash.com/photo-1581092160607-ee22621dd758') no-repeat center/cover;
    font-family: Arial;
}

.overlay {
    background: rgba(0,0,0,0.7);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.form-card {
    background: white;
    padding: 25px;
    border-radius: 15px;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.4);
    position: relative;
}

.back-btn {
    position: absolute;
    top: 15px;
    left: 15px;
    border-radius: 50%;
}

h3 {
    text-align: center;
    margin-bottom: 20px;
}

.form-control {
    border-radius: 10px;
}

.btn-custom {
    width: 100%;
    border-radius: 25px;
    background: linear-gradient(to right, #ff7e5f, #feb47b);
    color: white;
    font-weight: bold;
}
</style>

<script>
// 🔥 LIVE VALIDATION
function onlyLetters(e){
    let char = String.fromCharCode(e.which);
    if(!/[A-Za-z ]/.test(char)) return false;
}

function alphaNumeric(e){
    let char = String.fromCharCode(e.which);
    if(!/[A-Za-z0-9 ]/.test(char)) return false;
}
</script>

</head>

<body>

<div class="overlay">
<div class="form-card">

<a href="dashboard.php" class="btn btn-light back-btn">⬅</a>

<h3>Add Work</h3>

<!-- ✅ MESSAGE -->
<?php echo $msg; ?>

<form method="POST">

<input type="text" name="work" placeholder="Work Name"
class="form-control mb-3"
onkeypress="return onlyLetters(event)"
required>

<input type="text" name="place" placeholder="Work Place"
class="form-control mb-3"
onkeypress="return alphaNumeric(event)"
required>

<input type="number" name="wage" placeholder="Wage" class="form-control mb-3" required>

<input type="date" name="date" class="form-control mb-3" required>

<input type="number" name="hours" placeholder="Hours" class="form-control mb-3" required>

<button class="btn btn-custom">Add Work</button>

</form>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $uid = $_SESSION['user_id'];
    $work = trim($_POST['work']);
    $place = trim($_POST['place']);
    $wage = $_POST['wage'];
    $date = $_POST['date'];
    $hours = $_POST['hours'];

    // ❌ WORK NAME VALIDATION (ONLY LETTERS)
    if(!preg_match("/^[A-Za-z ]+$/", $work)){
        $msg = "<div class='alert alert-danger mt-3 text-center'>
                ❌ Work name should contain only alphabets
                </div>";
    }

    // ❌ PLACE SHOULD NOT BE ONLY NUMBERS
    elseif(preg_match("/^[0-9]+$/", $place)){
        $msg = "<div class='alert alert-danger mt-3 text-center'>
                ❌ Place should not be only numbers (use letters or alphanumeric)
                </div>";
    }

    // ❌ PLACE VALIDATION (ALPHANUMERIC)
    elseif(!preg_match("/^[A-Za-z0-9 ]+$/", $place)){
        $msg = "<div class='alert alert-danger mt-3 text-center'>
                ❌ Place should be alphabets or alphanumeric only
                </div>";
    }

    else {

        // CHECK DUPLICATE DATE
        $check = $conn->query("SELECT * FROM works WHERE user_id='$uid' AND work_date='$date'");

        if($check->num_rows > 0){
            $msg = "<div class='alert alert-danger mt-3 text-center'>
                    Already added work for this date
                    </div>";
        } 
        else {

            $conn->query("INSERT INTO works(user_id,work_name,place,wage,work_date,hours)
            VALUES('$uid','$work','$place','$wage','$date','$hours')");

            $msg = "<div class='alert alert-success mt-3 text-center'>
                    ✅ Work Added Successfully
                    </div>";
        }
    }

    // 🔁 SHOW MESSAGE AFTER PROCESS
    echo $msg;
}
?>

</div>
</div>

</body>
</html>