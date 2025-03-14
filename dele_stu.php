<?php
include('config.php');  

session_start();

 
if (isset($_GET['delete_id'])) {
    $student_id = $_GET['delete_id']; 
    $message = "";

    try {
        mysqli_begin_transaction($conn);

        $sql_delete_student = "DELETE FROM students WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql_delete_student);
        mysqli_stmt_bind_param($stmt, "i", $student_id);  
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        mysqli_commit($conn);

        $_SESSION['message'] = "Student deleted successfully.";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $_SESSION['message'] = "Error deleting student: " . $e->getMessage();
    }
}

 
$sql = "SELECT * FROM students";
$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body, h1, h2, table, th, td {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }
        body {
            background-color: #f4f7fc;
            color: #333;
            font-size: 16px;
            line-height: 1.6;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
        }
        h2 {
            color: #34495e;
            font-size: 22px;
            margin-bottom: 10px;
        }
        .message {
            padding: 15px;
            background-color: #eaf7e3;
            color: #2c3e50;
            border-radius: 5px;
            border-left: 5px solid #2ecc71;
            margin-bottom: 20px;
            text-align: center;
        }
        .message.error {
            background-color: #f8d7da;
            border-left-color: #e74c3c;
            color: #e74c3c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: #fff;
            font-weight: normal;
        }
        td {
            background-color: #f9f9f9;
        }
        tr:hover td {
            background-color: #f1f1f1;
        }
        .btn-delete {
            background-color: #e74c3c;
            color: #fff;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .btn-delete:hover {
            background-color: #c0392b;
        }
        .btn-back {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
        }
        .btn-back:hover {
            background-color: #2980b9;
        }
        @media (max-width: 768px) {
            table {
                width: 100%;
            }
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Student Management System</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="message <?php echo strpos($_SESSION['message'], 'Error') !== false ? 'error' : ''; ?>">
            <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <h2>Available Students</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Student ID</th>
                <th>Year of Study</th>
                <th>Program</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['year_of_study']); ?></td>
                    <td><?php echo htmlspecialchars($row['program']); ?></td>
                    <td>
                        <a href="?delete_id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn-back">Back to Dashboard</a>
</div>
</body>
</html>