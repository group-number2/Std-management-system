<?php
session_start();
include('config.php');

 
if (isset($_POST['login'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $student_name = mysqli_real_escape_string($conn, $_POST['student_name']);

    
    $sql = "SELECT * FROM students WHERE student_id = '$student_id' AND student_name = '$student_name'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $student = mysqli_fetch_assoc($result);
        $_SESSION['student_id'] = $student['id'];   
        $_SESSION['student_name'] = $student['student_name'];
        header("Location: grade.cal.php");   
        exit();
    } else {
        $error = "Invalid Student ID or Name!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-container { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 300px; }
        h2 { text-align: center; color: #333; }
        input[type="text"], input[type="submit"] { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; }
        input[type="submit"] { background-color: #007BFF; color: white; border: none; cursor: pointer; }
        input[type="submit"]:hover { background-color: #0056b3; }
        .error { color: red; text-align: center; }
        .logout-btn
        { margin-top: 20px;
        padding:10px 20px;
    background-color: #007BFF;
color:white;
border: none;
cursor: pointer;
border-radius: 10px;
 width: 100%;}
    </style>
</head>
<body>

<div class="login-container">
    <h2>Student Login</h2>
    <form method="POST" action="">
        <label for="student_name">Student Name:</label>
        <input type="text" name="student_name" required placeholder="Enter your Name">
        
        <label for="student_id">Student ID:</label>
        <input type="text" name="student_id" required placeholder="Enter your Student ID">
        
        <input type="submit" name="login" value="Login">
       

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </form>
    <form method="POST" action="dashboard.php">
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</div>

</body>
</html>
