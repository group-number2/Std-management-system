<?php
session_start([ 
    'cookie_lifetime' => 86400, 
    'cookie_secure'   => true,  
    'cookie_httponly' => true,  
    'use_strict_mode' => true  
]);


ini_set('display_errors', 0);  
ini_set('log_errors', 1);    

include('config.php');  
header("Content-Security-Policy: default-src 'self'");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");

if (!isset($_SESSION['allowed_batch']) || empty($_SESSION['allowed_batch'])) {
    die("<h1>Error: Batch not set. Please log in again.</h1>");
}


try {
    
    $query = "SELECT students.id, students.name, courses.name AS course_name, 
                     grades.grade, attendance.status
              FROM students
              LEFT JOIN attendance ON students.id = attendance.student_id
              LEFT JOIN grades ON students.id = grades.student_id
              LEFT JOIN courses ON grades.course_id = courses.id
              WHERE students.batch = ?";  
    
    
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        throw new Exception("Database error: Unable to prepare query.");
    }
    $stmt->bind_param("i", $_SESSION['allowed_batch']); 
    $stmt->execute();
    $result = $stmt->get_result();
    
} catch (Exception $e) {
    
    error_log("Database error: " . $e->getMessage());
    exit('<h1>System Maintenance</h1><p>Please try again later</p>');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Course Grades & Attendance</title>
    <link rel="stylesheet" href="style2.css">
    <script>
        
        function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll("table tr");

            for (var i = 0; i < rows.length; i++) {
                var row = [], cols = rows[i].querySelectorAll("td, th");

                for (var j = 0; j < cols.length; j++) {
                    row.push(cols[j].innerText);
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

<div id="page-content-wrapper">
    <h2 class="text-center">📊 Student Course Grades & Attendance</h2>

    <table class="report-table">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Grade</th>
                <th>Attendance Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
           
            while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id'], ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES); ?></td>
                <td><?php echo htmlspecialchars($row['course_name'], ENT_QUOTES); ?></td>
                <td><?php echo isset($row['grade']) ? htmlspecialchars($row['grade']) : 'No grade'; ?></td>
                <td><?php echo isset($row['status']) ? htmlspecialchars($row['status']) : 'Absent'; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <button onclick="exportTableToCSV('student_report_<?php echo date('Y-m-d'); ?>.csv')">📥 Export as CSV</button>
</div>

</body>
</html>
