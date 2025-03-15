<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Academic Rules</title>
    
</head>
<style> 
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
 
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fa;
    color: blue;
    padding: 50px 20px;
}

 
.container {
    max-width: 1000px;
    margin: 0 auto;
    background-color: #ffffff;
    padding: 40px;
    border-radius: 15px;
    
}

 
h2 {
    font-size: 40px;
    text-align: center;
    color: #e74c3c;
    margin-bottom: 40px;
    font-weight: bold;
}

 
h3 {
    font-size: 28px;
    color: #2980b9;
    margin-bottom: 20px;
    font-weight: 500;
    text-transform: uppercase;
    border-bottom: 3px solid #2980b9;
    padding-bottom: 10px;
}

 
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    padding: 18px;
    text-align: left;
    font-size: 16px;
    color: #34495e;
}

th {
    background-color: #3498db;
    color: white;
    font-weight: bold;
    text-transform: uppercase;
}

tbody tr {
    border-bottom: 1px solid #f1f1f1;
}

tbody tr:hover {
    background-color: #ecf0f1;
}

tbody tr:nth-child(odd) {
    background-color: #fafafa;
}

 
ul {
    margin: 20px 0;
    padding-left: 25px;
    font-size: 16px;
    line-height: 1.7;
}

ul li {
    margin-bottom: 12px;
}

ul li::before {
    
    color: #2ecc71;
    margin-right: 10px;
}
 
 

 

.btn-back{
    background-color: #3498db;
    color:white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    margin-top: 20px;
    display: inline-block;
    
}
</style>

<body>

    <div class="container">
        <h2>University of Haramaya - Academic Regulations</h2>

        <h3>Grading System</h3>
        <p>The University of Haramaya follows the following grading system for undergraduate programs:</p>
        <table>
            <thead>
                <tr>
                    <th>Grade</th>
                    <th>GPA Range</th>
                    <th>Grade Points</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>A</td>
                    <td>90 - 100</td>
                    <td>4.00</td>
                </tr>
                <tr>
                    <td>A</td>
                    <td>85 -89 </td>
                    <td>3.75</td>
                </tr>
                <tr>
                    <td>A-</td>
                    <td>80 -85 </td>
                    <td>3.75</td>
                </tr>
                <tr>
                    <td>B+</td>
                    <td>75 - 79</td>
                    <td>3.50</td>
                </tr>
                <tr>
                    <td>B</td>
                    <td>70 - 74</td>
                    <td>3.00</td>
                </tr>
                <tr>
                    <td>B-</td>
                    <td>65 -69 </td>
                    <td>3.75</td>
                </tr>
                <tr>
                    <td>C+</td>
                    <td>60 - 64</td>
                    <td>2.50</td>
                </tr>
                <tr>
                    <td>C</td>
                    <td>50 - 59</td>
                    <td>2.00</td>
                </tr>
                <tr>
                    <td>D</td>
                    <td>40 - 49.99</td>
                    <td>1.50</td>
                </tr>
                
                <tr>
                    <td>F</td>
                    <td>0 - 29.99</td>
                    <td>0.00</td>
                </tr>
            </tbody>
        </table>

        <h3>Attendance Policy</h3>
        <ul>
            <li>Students must attend at least 75% of the classes for each course to be eligible for exams.</li>
            <li>Any student who misses more than 25% of the classes will not be allowed to sit for the final exam for that course.</li>
            <li>Absences due to illness or emergencies must be reported to the instructor and may require documentation (e.g., doctor's note).</li>
        </ul>

        <h3>Course Completion</h3>
        <p>To successfully complete a course, students must:</p>
        <ul>
            <li>Achieve a final grade of at least a D (1.00 GPA).</li>
            <li>Pass all the required assignments, exams, and projects within the deadlines.</li>
        </ul>

         
        
        <h3>Grade Point Average (GPA) Calculation</h3>
        <p>The GPA is calculated as follows:</p>
        <ul>
            <li>Each grade is assigned a grade point.</li>
            <li>The GPA is the average of the grade points earned, weighted by the number of credits for each course.</li>
            <li>The formula for GPA calculation is:</li>
            <pre>GPA = (Grade Points of Course 1 * Credits) + (Grade Points of Course 2 * Credits) + ...</pre>
            <li>The final GPA will be the total weighted grade points divided by the total number of credits completed.</li>
        </ul>

        <h3>Course Withdrawal</h3>
        <p>Students can withdraw from a course before the withdrawal deadline. A "W" grade will be recorded for the course on the transcript, but it does not affect the GPA. Withdrawal after the deadline is not permitted except under exceptional circumstances (e.g., medical emergency). Students are advised to consult with their academic advisor before withdrawing.</p>
        <a href="dashboard.php" class="btn-back">Back to Dashboard</a>
    </div>
     


</body>

</html>
