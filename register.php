<?php
session_start();
include('config.php');  

 
$departments = ["CCI", "HIT", "COBE", "CNCS", " college of Agri_cultural of science"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);  

    
    $check_query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Username already exists!";
    } else {
         
        $insert_query = "INSERT INTO users (username, password, department) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sss", $username, $hashed_password, $department);
        if ($stmt->execute()) {
            $_SESSION['username'] = $username;  
            header("Location: login.php");  
            exit();
        } else {
            $error = "Error registering user: " . $stmt->error;
        }
    }
}
?>

 
<form method="POST" action="">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>

    
    <label for="department">Select Department:</label>
    <select name="department" id="department" required>
        <?php
        foreach ($departments as $department) {
            echo "<option value=\"$department\">$department</option>";
        }
        ?>
    </select><br>

    <button type="submit">Register</button>
    <link rel="stylesheet" href="stsyle.css">
</form>

<?php
if (isset($error)) {
    echo "<p style='color:red;'>$error</p>"; 
}
?>
