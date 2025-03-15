<?php
session_start();
include('config.php');  

 
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

 
$query = "SELECT s.id, s.student_name, s.student_id, 
                 c.course_name, g.assignment_grade, g.midterm_grade, 
                 g.final_exam_grade, g.final_grade, a.status AS attendance_status
          FROM students s
          LEFT JOIN course_grades g ON s.id = g.student_id
          LEFT JOIN courses c ON g.course_id = c.id
          LEFT JOIN attendance a ON s.id = a.student_id";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

 
$num_rows = mysqli_num_rows($result);

 
function getGradeLetter($final_grade) {
    if (!is_numeric($final_grade)) return 'N/A';
    if ($final_grade >= 90) return 'A+';
    elseif ($final_grade >= 85) return 'A';
    elseif ($final_grade >= 80) return 'A-';
    elseif ($final_grade >= 75) return 'B+';
    elseif ($final_grade >= 70) return 'B';
    elseif ($final_grade >= 65) return 'B-';
    elseif ($final_grade >= 60) return 'C+';
    elseif ($final_grade >= 55) return 'C';
    elseif ($final_grade >= 50) return 'C-';
    elseif ($final_grade >= 40) return 'D';
    else return 'F';
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Report</title>
    <link rel="stylesheet" href="style2.css">
   
     
    
    <script>
        function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll("table tr");
            for (var i = 0; i < rows.length; i++) {
                var row = [], cols = rows[i].querySelectorAll("td, th");
                for (var j = 0; j < cols.length; j++) {
                    row.push('"' + cols[j].innerText.replace(/"/g, '""') + '"');
                }
                csv.push(row.join(","));
            }
            var csv_file = new Blob([csv.join("\n")], { type: "text/csv" });
            var link = document.createElement("a");
            link.download = filename;
            link.href = URL.createObjectURL(csv_file);
            link.click();
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Student Report</h2>
        <div class="debug">
            Logged in as: <?php echo htmlspecialchars($_SESSION['username']); ?><br>
            Rows found: <?php echo $num_rows; ?>
        </div>

        <?php if ($num_rows == 0): ?>
            <p class="no-data">No student records found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Course</th>
                        <th>Assignment</th>
                        <th>Midterm</th>
                        <th>Final Exam</th>
                        <th>Total</th>
                        <th>Grade</th>
                        <th>Attendance Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['student_id'], ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($row['student_name'], ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($row['course_name'] ?? 'N/A', ENT_QUOTES); ?></td>
                            <td><?php echo isset($row['assignment_grade']) ? htmlspecialchars($row['assignment_grade']) : 'N/A'; ?></td>
                            <td><?php echo isset($row['midterm_grade']) ? htmlspecialchars($row['midterm_grade']) : 'N/A'; ?></td>
                            <td><?php echo isset($row['final_exam_grade']) ? htmlspecialchars($row['final_exam_grade']) : 'N/A'; ?></td>
                            <td><?php echo isset($row['final_grade']) ? htmlspecialchars($row['final_grade']) : 'N/A'; ?></td>
                            <td><?php echo getGradeLetter($row['final_grade']); ?></td>
                            <td><?php echo htmlspecialchars($row['attendance_status'] ?? 'N/A', ENT_QUOTES); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button class="btn" onclick="exportTableToCSV('student_report_<?php echo date('Y-m-d'); ?>.csv')">Export to CSV</button>
        <?php endif; ?>
        <a href="dashboard.php" class="btn-back">Back to Dashboard</a>
    </div>
</body>
</html>