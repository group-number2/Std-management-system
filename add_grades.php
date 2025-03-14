<?php
session_start();
include('config.php');

 
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

 
$courses_query = "SELECT * FROM courses";
$courses_result = mysqli_query($conn, $courses_query);

 
$students_query = "SELECT * FROM students";
$students_result = mysqli_query($conn, $students_query);

 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);
    $assignment_grade = mysqli_real_escape_string($conn, $_POST['assignment_grade']);
    $midterm_grade = mysqli_real_escape_string($conn, $_POST['midterm_grade']);
    $final_exam_grade = mysqli_real_escape_string($conn, $_POST['final_exam_grade']);

    
    $final_grade = ($assignment_grade ) + ($midterm_grade ) + ($final_exam_grade );

    
    $query = "INSERT INTO course_grades (student_id, course_id, assignment_grade, midterm_grade, final_exam_grade, final_grade) 
              VALUES ('$student_id', '$course_id', '$assignment_grade', '$midterm_grade', '$final_exam_grade', '$final_grade')";
    
    if (mysqli_query($conn, $query)) {
        $success_message = "Grade added successfully!";
    } else {
        $error_message = "Error adding grade: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Grades</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="number"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn2 {
            width: 100%;
            padding: 10px;
            background-color:rgb(0, 255, 72);
            color: #fff;
            margin-top: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .alert {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Enter Grades</h2>

        <?php if (isset($success_message)) { ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php } ?>

        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>

        <!-- Grade Entry Form -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="student_id">Student</label>
                <select id="student_id" name="student_id" required>
                    <option value="">Select Student</option>
                    <?php while ($student = mysqli_fetch_assoc($students_result)) { ?>
                        <option value="<?php echo $student['id']; ?>"><?php echo $student['student_name']; ?> (<?php echo $student['student_id']; ?>)</option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="course_id">Course</label>
                <select id="course_id" name="course_id" required>
                    <option value="">Select Course</option>
                    <?php while ($course = mysqli_fetch_assoc($courses_result)) { ?>
                        <option value="<?php echo $course['id']; ?>"><?php echo $course['course_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="assignment_grade">Assignment </label>
                <input type="number" id="assignment_grade" name="assignment_grade" step="0.01" min="0" max="100" required>
            </div>
            <div class="form-group">
                <label for="midterm_grade">Midterm </label>
                <input type="number" id="midterm_grade" name="midterm_grade" step="0.01" min="0" max="100" required>
            </div>
            <div class="form-group">
                <label for="final_exam_grade">Final Exam </label>
                <input type="number" id="final_exam_grade" name="final_exam_grade" step="0.01" min="0" max="100" required>
            </div>

            <button type="submit" class="btn">Add Grade</button>
        </form>
 
        <form action="dashboard.php">
            <button type="submit" class="btn2">Logout</button>
        </form>
    </div>
</body>
</html>
