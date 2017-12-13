<!-- TODO
 - [DONE!] Display something, anything.
 - [DONE!] User name, id
 - [DONE!] Course tables
    - [DONE!] Normal
    - [DONE!] Elective
    - [DONE!] Mixed
    - Dropdown list for csc electives and math elective
 - [DONE!] Fields for GPA, credits completed, credits in progress
 - [DONE!] Progress bar
-->

<!DOCTYPE html>
<html>
<head>
    <title>Graduation Requirements</title>
    <link rel="stylesheet" type="text/css" href="checklist.css">
</head>

<body>
    <div class="stu-infobar">

        <p style="text-align:center;">Hello
            <?php 
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                
                $uname = $_SESSION['$uname']; 
                $filename = 'users/' . $uname . '.xml';
                $userxml = simplexml_load_file($filename);
                echo $userxml->name->first; 
            ?>!
            <br/>
            StudentID: <?php 
                echo $uname; 
            ?>
        </p>
        
        <div class="stu-info">
            Cumulative GPA:
            <input id="cumulative_gpa" type="number" value=0 readonly="readonly">
        </div>

        <div class="stu-info">
            Completed Credits:
            <input id="completed_credits" type="number" value=0 readonly="readonly">
        </div>

        <div class="stu-info">
            In Progress:
            <input id="in_progress" type="number" value=0 readonly="readonly">
        </div> 
    </div>
    
    <div id="course-tables">
    
        <?php 
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        
		    include 'builder.php';
		?>
    
    </div>
    
    <div class="stu-infobar">
        <h2>Degree Progress</h1>
        <div id="myProgress">
            <div id="myBar">10%</div>
        </div>
    </div>
   
</body>

</html>
