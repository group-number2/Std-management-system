<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management Dashboard</title>
    <link rel="stylesheet" href="dash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<header>
    <img src="logo.webp" alt="this ">
    <h2>Welcome to  our platform </h2>
    <nav>
        <li><a href="#contact">contact</a></li>
    </nav>
</header>

<?php
session_start();
include('config.php');
 
$total_students_query = "SELECT COUNT(*) AS total FROM students";
$total_students_result = mysqli_query($conn, $total_students_query);
$total_students_row = mysqli_fetch_assoc($total_students_result);
$total_students = $total_students_row['total'];

 
$total_courses_query = "SELECT COUNT(*) AS total FROM courses";
$total_courses_result = mysqli_query($conn, $total_courses_query);
$total_courses_row = mysqli_fetch_assoc($total_courses_result);
$total_courses = $total_courses_row['total'];

 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
 

 

<body style="display: flex; flex-direction: column; min-height: 100vh;">
    <div class="wrapper">
        
        <div class="sidebar">
            <div class="sidebar-heading"> Student Management</div>
            <div class="sidebar-links">
                <a href="#">Dashboard</a>
                <a href="add_student.php"> Add Student</a>
                <a href="add_grades.php"> Add Grades</a>
                <a href="report.php"> Reports</a>
                <a href="view_students.php"> View Students</a>
                <a href="view_coure.php"> View Courses</a>
                <a href="add_course.php"> Add Course</a>
                <a href="academic_details.php"> Academic Details</a>
                <a href="grade.cal.php">©Grade Calculator</a>
                <a href="attendece.php"> Attendance</a>
                <a href="dele_stu.php"> delete_student</a>
                
            </div>
        </div>

       
        <div class="content" style="flex-grow: 1;">
            <nav class="navbar">
                <div class="navbar-inner">
                    <h5>Welcome, <?php echo "MR." . $_SESSION['username'] ; ?>!   what do you want</h5>
                    <div class="navbar-right">
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </nav>

            <div class="dashboard">
                <h2>Dashboard Overview</h2>
                <div class="dashboard-cards">
                    <div class="card">
                        <h5>Total Students</h5>
                        <h3><?php echo $total_students; ?></h3>
                    </div>
                    <div class="card">
                        <h5>Total Courses</h5>
                        <h3><?php echo $total_courses; ?></h3>
                    </div>
                     
                </div>

                <div class="actions">
                    <a href="add_student.php" class="btn"> Add Student</a>
                    <a href="add_grades.php" class="btn"> Enter Grades</a>
                    <a href="report.php" class="btn"> Reports</a>
                    <a href="view_students.php" class="btn"> View Students</a>
                    
                    
                </div>
            </div>
        </div>
    </div>

   
    <footer class="footer" id="contact">
  <div class="container grid grid-footer">
    <div class="address-col">
      <p class="footer-heading">Contact us</p>
      <address class="contacts">
        <ul class="social-links">
          <li><a href="https://www.instagram.com" target="_blank"><ion-icon name="logo-instagram" class="icons"></ion-icon></a></li>
          <li><a href="https://www.facebook.com" target="_blank"><ion-icon name="logo-facebook" class="icons"></ion-icon></a></li>
          <li><a href="https://www.twitter.com" target="_blank"><ion-icon name="logo-twitter" class="icons"></ion-icon></a></li>
        </ul>
        <p class="address">
          Harar/Haramaya University, Software Department 2024
        </p>
        <p>
          <a class="footer-link" href="tel:+251-166-629-82">+251916662982/+25193776800/+251920208908/+251918356227</a><br>
          <a class="footer-link" href="mailto:hello@studentmanagementSystem.com">hello@studentmanagementSystem.com</a>
        </p>
      </address>
    </div>

    <nav class="nav-col">
      <p class="footer-heading">Quick Links</p>
      <ul class="footer-nav">
        <li><a class="footer-link" href="https://github.com/group-number2" target="_blank">GitHub</a></li>
        <li><a class="footer-link" href="https://t.me/Mukti57" target="_blank">Telegram</a></li>
        <li><a class="footer-link" href="#facebook">Facebook</a></li>
        <li><a class="footer-link" href="#instagram">Instagram</a></li>
      </ul>
    </nav>
  </div>

  <div class="copyright">
    <p class="copright">
      Copyright &copy; <span class="year">2025</span> Student Management System, All rights reserved.
    </p>
  </div>
</footer>

</body>

</html>
