<?php
session_start();
include('config.php');

 
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$success_message = '';
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $student_name = mysqli_real_escape_string($conn, $_POST['student_name']);
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $program = mysqli_real_escape_string($conn, $_POST['program']);
    $year_of_study = mysqli_real_escape_string($conn, $_POST['year_of_study']);

    
    mysqli_begin_transaction($conn);

    try {
         
        $query = "INSERT INTO students (student_name, student_id, program, year_of_study) 
                  VALUES ('$student_name', '$student_id', '$program', '$year_of_study')";
        if (!mysqli_query($conn, $query)) {
            throw new Exception("Error adding student: " . mysqli_error($conn));
        }

        
        $last_student_id = mysqli_insert_id($conn);

 
        $academic_query = "INSERT INTO academic_details (student_id, student_name, program, year_of_study) 
                           VALUES ('$last_student_id', '$student_name', '$program', '$year_of_study')";
        if (!mysqli_query($conn, $academic_query)) {
            throw new Exception("Error adding academic details: " . mysqli_error($conn));
        }

      
        mysqli_commit($conn);
        $success_message = "Student and academic details added successfully!";
    } catch (Exception $e) {
       
        mysqli_rollback($conn);
        $error_message = $e->getMessage();
    }
}

 
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
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

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn2 {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            margin-top: 10px;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn2:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Student</h2>

        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
            <form action="dashboard.php">
                <button type="submit" class="btn2">Go to Dashboard</button>
            </form>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if (!$success_message):   ?>
            <form method="POST" action="">
                <label for="student_name" class="form-label">Student Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name" required>

                <label for="student_id" class="form-label">Student ID</label>
                <input type="text" class="form-control" id="student_id" name="student_id" required>

                <label for="program" class="form-label">Program</label>
                <input type="text" class="form-control" id="program" name="program" required>

                <label for="year_of_study" class="form-label">Year of Study</label>
                <input type="number" class="form-control" id="year_of_study" name="year_of_study" required>

                <button type="submit" class="btn-primary">Add Student</button>
            </form>
            
            <form action="dashboard.php">
                <button type="submit" class="btn2">Back to Dashboard</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>