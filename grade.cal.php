<?php
session_start();
include('config.php');

 
if (!isset($_SESSION['student_id'])) {
    header("Location: login2.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];
$default_credit_hour = 3; // Use 3 credit hours for all subjects

 
$sql_courses = "
    SELECT c.course_name, 
           cg.assignment_grade, cg.midterm_grade, cg.final_exam_grade
    FROM course_grades cg
    JOIN courses c ON cg.course_id = c.id
    WHERE cg.student_id = $student_id
";
$courses_result = mysqli_query($conn, $sql_courses);

$total_weighted_gpa = 0;
$total_credit_hours = 0;
$course_details = [];

if ($courses_result && mysqli_num_rows($courses_result) > 0) {
    while ($row = mysqli_fetch_assoc($courses_result)) {
        $course_name = $row['course_name'];
        $assignment_grade = $row['assignment_grade'];
        $midterm_grade = $row['midterm_grade'];
        $final_exam_grade = $row['final_exam_grade'];

        
        $final_grade = $assignment_grade + $midterm_grade + $final_exam_grade;

         
        $grade_info = getLetterGrade($final_grade);
        
   
        $course_details[] = [
            'course_name' => $course_name,
            'credit_hour' => $default_credit_hour,   
            'assignment_grade' => $assignment_grade,
            'midterm_grade' => $midterm_grade,
            'final_exam_grade' => $final_exam_grade,
            'final_grade' => $final_grade,
            'letter_grade' => $grade_info['letter_grade'],
            'gpa' => $grade_info['gpa']
        ];

       
        $total_weighted_gpa += $grade_info['gpa'] * $default_credit_hour;
        $total_credit_hours += $default_credit_hour;
    }
}

 
$cgpa = ($total_credit_hours > 0) ? round($total_weighted_gpa / $total_credit_hours, 2) : "N/A";

 
function getLetterGrade($grade) {
    if ($grade >= 90) {
        return ['letter_grade' => 'A+', 'gpa' => 4.00];
    } elseif ($grade >= 85) {
        return ['letter_grade' => 'A', 'gpa' => 3.75];
    } elseif ($grade >= 80) {
        return ['letter_grade' => 'A-', 'gpa' => 3.50];
    } elseif ($grade >= 75) {
        return ['letter_grade' => 'B+', 'gpa' => 3.25];
    } elseif ($grade >= 70) {
        return ['letter_grade' => 'B', 'gpa' => 3.00];
    } elseif ($grade >= 65) {
        return ['letter_grade' => 'B-', 'gpa' => 2.75];
    } elseif ($grade >= 60) {
        return ['letter_grade' => 'C+', 'gpa' => 2.50];
    } elseif ($grade >= 50) {
        return ['letter_grade' => 'C', 'gpa' => 2.00];
    } elseif ($grade >= 40) {
        return ['letter_grade' => 'D', 'gpa' => 1.50];
     } else {
        return ['letter_grade' => 'F', 'gpa' => 0.00];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; text-align: center; padding-top: 50px; }
        .dashboard { background: #fff; padding: 30px; border-radius: 8px; width: 90%; margin: 0 auto; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); }
        h2 { color: #333; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table, .table th, .table td { border: 1px solid #ddd; }
        .table th, .table td { padding: 10px 12px; text-align: center; }
        .table th { background-color: #007BFF; color: white; }
        .cgpa { font-size: 24px; font-weight: bold; color: #007BFF; }
        .logout-btn { margin-top: 20px; padding: 10px 20px; background-color: #f44336; color: white; border: none; cursor: pointer; border-radius: 5px; }
        .logout-btn:hover { background-color: #d32f2f; }
    </style>
</head>
<body>

<div class="dashboard">
    <h2>Welcome, <?php echo $student_name; ?>!</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Credit Hour</th>
                <th>Assignment </th>
                <th>Midterm </th>
                <th>Final Exam </th>
                <th> total</th>
                <th> Grade</th>
                <th>GPA</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($course_details as $course) { ?>
                <tr>
                    <td><?php echo $course['course_name']; ?></td>
                    <td><?php echo $course['credit_hour']; ?></td>
                    <td><?php echo round($course['assignment_grade'], 2); ?></td>
                    <td><?php echo round($course['midterm_grade'], 2); ?></td>
                    <td><?php echo round($course['final_exam_grade'], 2); ?></td>
                    <td><?php echo round($course['final_grade'], 2); ?></td>
                    <td><?php echo $course['letter_grade']; ?></td>
                    <td><?php echo $course['gpa']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="7"><strong>CGPA</strong></td>
                <td class="cgpa"><?php echo $cgpa; ?></td>
            </tr>
        </tbody>
    </table>

    
    <form method="POST" action="dashboard.php">
        <button type="submit" class="logout-btn">Logout</button>
    </form>
    <form method="POST" action="login2.php">
        <button type="submit" class="logout-btn">Re-entry</button>
    </form>
</div>

</body>
</html>
