<?php
session_start();
include('config.php');

 
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_code = mysqli_real_escape_string($conn, $_POST['course_code']);
    $course_name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $instructor = mysqli_real_escape_string($conn, $_POST['instructor']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);

    
    $query = "INSERT INTO courses (course_code, course_name, instructor, department) 
              VALUES ('$course_code', '$course_name', '$instructor', '$department')";
    if (mysqli_query($conn, $query)) {
        $success_message = "Course added successfully!";
        
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Error adding course: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .alert {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn-primary {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn2 {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Add Course</h2>

        <?php if (isset($success_message)) { ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php } ?>

        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>

       
        <form method="POST" action="">
            <label for="course_code" class="form-label">Course Code</label>
            <input type="text" class="form-control" id="course_code" name="course_code" required>

            <label for="course_name" class="form-label">Course Name</label>
            <input type="text" class="form-control" id="course_name" name="course_name" required>

            <label for="instructor" class="form-label">Instructor</label>
            <input type="text" class="form-control" id="instructor" name="instructor" required>

            <label for="department" class="form-label">Department</label>
            <input type="text" class="form-control" id="department" name="department" required>

            <button type="submit" class="btn-primary">Add Course</button>
        </form>
        <form action="dashboard.php">
            <button type="submit" class="btn2">Logout</button>
        </form>
    </div>
</body>

</html>
