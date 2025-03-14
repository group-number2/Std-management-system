<?php
 
session_start([
    'cookie_lifetime' => 86400,
    'cookie_secure'   => true,
    'cookie_httponly' => true,
    'use_strict_mode' => true
]);

 
ini_set('display_errors', 1);  
ini_set('log_errors', 1);     

 
include('config.php');  

 
header("Content-Security-Policy: default-src 'self'");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");

try {
 
    $query = "SELECT id, course_code, course_name, instructor,department FROM courses";
    
    
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Query preparation failed: ' . $conn->error);
    }
    
     
    $stmt->execute();
    $result = $stmt->get_result();
    
     
    if ($result->num_rows == 0) {
        throw new Exception('No courses found.');
    }

} catch (Exception $e) {
    error_log("Database error: " . $e->getMessage());
    echo '<h1>System Maintenance</h1><p>Please try again later. Error: ' . $e->getMessage() . '</p>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Courses</title>
    <link rel="stylesheet" href="cour.css">
    
</head>

<body>

    <div class="container">
        <h2>📚 List of Available Courses</h2>

         
        <?php if ($result->num_rows == 0): ?>
            <p>No courses available at the moment. Please check back later.</p>
        <?php else: ?>
       
            <table class="course-table">
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>instructor</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['course_code'], ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($row['course_name'], ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($row['instructor'], ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($row['department'], ENT_QUOTES); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php endif; ?>

        
        <a href="dashboard.php" class="btn-back">Back to Dashboard</a>

        
        <a href="add_course.php" class="btn-add-course">Add New Course</a>
    </div>

</body>

</html>
