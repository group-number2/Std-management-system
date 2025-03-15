<?php
session_start();
include('config.php');  

 
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

 
$success_message = '';
$error_message = '';

 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = intval($_POST['student_id']);  
    $attendance_status = $_POST['attendance_status'];
    $course_id = 1; 

     
    $valid_statuses = ['Present', 'Absent'];  
    if (!in_array($attendance_status, $valid_statuses)) {
        $error_message = "Invalid attendance status selected.";
    } else {
         
        $check_query = "SELECT id FROM attendance WHERE student_id = ? AND date = CURDATE()";
        $stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($stmt, "i", $student_id);
        mysqli_stmt_execute($stmt);
        $check_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($check_result) > 0) {
           
            $update_query = "UPDATE attendance SET status = ? WHERE student_id = ? AND date = CURDATE()";
            $stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($stmt, "si", $attendance_status, $student_id);
        } else {
          
            $update_query = "INSERT INTO attendance (student_id, course_id, date, status) VALUES (?, ?, CURDATE(), ?)";
            $stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($stmt, "iis", $student_id, $course_id, $attendance_status);
        }

        if (mysqli_stmt_execute($stmt)) {
            $success_message = "Attendance updated successfully for student ID: " . htmlspecialchars($student_id);
        } else {
            $error_message = "Error updating attendance: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}

 
$query = "SELECT s.id, s.student_name,
                 SUM(CASE WHEN a.status = 'Present' THEN 1 ELSE 0 END) AS present_days,
                 SUM(CASE WHEN a.status = 'Absent' THEN 1 ELSE 0 END) AS absent_days
          FROM students s
          LEFT JOIN attendance a ON s.id = a.student_id
          GROUP BY s.id, s.student_name";

$result = mysqli_query($conn, $query) or die("Query failed: " . mysqli_error($conn));

 
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            padding: 20px;
            margin: 0;
        }
        #page-content-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2.text-center {
            color: #2c3e50;
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
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
            border-left: 5px solid #2ecc71;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 5px solid #e74c3c;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .report-table th, .report-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .report-table th {
            background-color: #3498db;
            color: #fff;
            font-weight: normal;
        }
        .report-table td {
            background-color: #f9f9f9;
        }
        .report-table tr:hover td {
            background-color: #f1f1f1;
        }
        .report-table select {
            padding: 5px;
            border-radius: 4px;
        }
        .report-table button {
            background-color: #4CAF50;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .report-table button:hover {
            background-color: #45a049;
        }
        .btn-back {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            text-align: center;
        }
        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="page-content-wrapper">
        <h2 class="text-center">📊 Student Attendance Reports</h2>

        <?php if ($success_message): ?>
            <div class="alert alert-success">
                <strong>Success!</strong> <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-danger">
                <strong>Error!</strong> <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <?php if (mysqli_num_rows($result) == 0): ?>
            <p style="text-align: center; color: #721c24;">No attendance records found.</p>
        <?php else: ?>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Present</th>
                        <th>Absent</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['present_days'] ?? 0); ?></td>
                            <td><?php echo htmlspecialchars($row['absent_days'] ?? 0); ?></td>
                            <td>
                                <form action="" method="POST">
                                    <input type="hidden" name="student_id" value="<?php echo $row['id']; ?>">
                                    <select name="attendance_status">
                                        <option value="Present">Present</option>
                                        <option value="Absent">Absent</option>
                                    </select>
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <a href="dashboard.php" class="btn-back">Back to Dashboard</a>
    </div>
</body>
</html>