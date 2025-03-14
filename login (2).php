<?php
session_start();
include('config.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['department'] = $user['department']; 
            header("Location: dashboard.php"); 
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not registered! <a href='register.php'>Register Here</a>";
    }

    $stmt->close();
    $conn->close();
}
?>

<form method="POST" action="">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
    <p>Don't have an account? <a href="register.php">Register Here</a></p>
    <link rel="stylesheet" href="stsyle.css">
</form>

<?php
if (isset($error)) {
    echo "<p style='color:red;'>$error</p>"; 
}
?>