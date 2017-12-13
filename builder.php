<?php
    // function declares arrays and calls create_table
    $csc_fresh = array("CSC 110", "CSC 150/L", "CSC 250", "CSC 251");
    create_table($csc_fresh, "cscfresh", "cscfreshheader", "CSC Freshman", 
        "background-color: rgb(7, 29, 73);");
    
    $csc_soph = array("CSC 300", "CSC 314");
    create_table($csc_soph, "cscsoph", "cscsophheader", "CSC Sophomore", 
        "background-color: rgb(7, 29, 73);");
    
    $csc_jun = array("CSC 317", "CSC 372", "CSC 461", "CSC 468", "CSC 470", 
    "CSC 484");
    create_table($csc_jun, "cscjun", "cscjunheader", "CSC Junior", 
        "background-color: rgb(7, 29, 73);");
    
    $csc_sen = array("CSC 464", "CSC 465", "CSC 456");
    create_table($csc_sen, "cscsen", "cscsenheader", "CSC Senior", 
        "background-color: rgb(7, 29, 73);");
    
    $csc_elect = array("CSC Elective", "CSC Elective", "CSC Elective", 
    "CSC Elective");
    create_table($csc_elect, "cscelect", "cscelectheader", 
        "CSC Electives", "background-color: rgb(7, 29, 73);");
    
    $math = array("MATH 123", "MATH 125", "MATH 225", "MATH 315", 
        "MATH 381", "MATH Elective");
    create_table($math, "math", "mathheader", "Math", 
        "background-color: rgb(7, 29, 73);");
    
    $sci = array("PHYS 211", "Science", "Science", "Science Lab", 
        "Science Lab");
    create_table($sci, "sci", "sciheader", "Science", 
        "background-color: rgb(7, 29, 73);");

    $gen_ed = array("Social Science", "Social Science", "Arts/Humanities", 
    "Arts/Humanities", "SS/Arts/Hum");
    create_table($gen_ed, "gened", "genedheader", "Gen Ed", 
        "background-color: rgb(7, 29, 73);");

    $free = array("Free Elective", "Free Elective", "Free Elective", 
    "Free Elective", "Free Elective", "Free Elective");
    create_table($free, "free", "freeheader", "Free Electives", 
        "background-color: rgb(7, 29, 73);");
    
    $engl = array("ENGL 101", "ENGL 279", "ENGL 289");
    create_table($engl, "engl", "englheader", "English", 
        "background-color: rgb(7, 29, 73);");
    
    function create_table($course_group, $tableid, $headerid, $group_name, 
        $color) {       
        
        // variable declarations
        $credits;
        $is_readonly;
        $prereqs;
        $coreqs;
        $courses = simplexml_load_file("courses.xml");
        
	    foreach($course_group as $course) {
	        $split = explode(" ", $course);
	        
	        if(sizeof($split) == 2) {
	            if($split[1] == '150/L') {
	                $split[1] = '150';
                }
                
                //echo "Split size = " . sizeof($split);
            
                if($split[0] == 'Free') {
                    $is_readonly[] = '';
                    $credits[] = 1;
                }
                else if($split[1] == 'Elective' || $split[1] == 'Science') {
                    $is_readonly[] = '';
                    $credits[] = 3;
                }
                else if($split[1] == 'Lab') {
                    $is_readonly[] = '';
                    $credits[] = 1;
                }
                else {
                    foreach($courses->course as $xmlcourse) {
                        if ($split[0] == $xmlcourse->prefix && 
                            $split[1] == $xmlcourse->number) {
                            // echo "xmlcredits = " . $xmlcourse->credits;
                            $is_readonly[] = 'readonly';
                            if($split[1] == '150') 
                                $credits[] = $xmlcourse->credits[0]+1;
                            else
                                $credits[] = $xmlcourse->credits[0]+0;
                        }
                        
                        // TODO: Fill prereq and coreq arrays here
                    }
                }
            }
            else {
                $is_readonly[] = '';
                $credits[] = 3;
            }
        }
        // echo "Element = " . $credits[1];
        // echo "Credits = ";
        // print_r($credits[0]);
        
        echo "<div class='table_container'>";
        echo    "<table class='table' id=$tableid>";
        echo        "<tr id=$headerid>";
        
        echo            "<td><input class='table_header' style='$color' type='text'  readonly value='$group_name' ></td>";    
		// to be updated by JS onload
        echo            "<td><input class='table_header' style='$color' type='text' readonly value='0'></td>";
	    echo            "<td><input class='table_header' style='$color' type='number' readonly value='0.00'></td>";
	    
	    echo        "</tr>";
	    
	    // function call to create rows
	    create_rows($course_group, $credits, $is_readonly);
		
		echo    "</table>";
	    echo "</div>";
    }
    
    function create_rows($course_group, $credit_arr, $is_readonly)
    {
        $option = array("null", "4", "3", "2", "1", "0", "EX", "Enrolled");
        $grade = array("", "A", "B", "C", "D", "F", "EX", "Enrolled");
        $j = 0;
    
        // echo "Credit_arr element 2 = " . $credit_arr[2];
        // print_r( $credit_arr);
    
        foreach($course_group as $course) {
            $course_nospaces = str_replace(" ", "", $course);
            
            // echo "j = " . $j;
            // echo $split[0].$split[1];
            // echo "Credit_arr." . $i . $credit_arr[$i];
            
            echo "<tr id=$course_nospaces>";
		    echo "<td><input $is_readonly[$j] type='text' value='$course'></td>";
			echo "<td><input $is_readonly[$j] type='number' value=$credit_arr[$j]></td>";
			echo "<td><select>";
				
            $n = sizeof($option);
            for ($i = 0; $i < $n; $i++) {
                echo "<option value=$option[$i]>";
                if($option[$i] != "null")
                    echo $grade[$i];
                echo "</option>";
            }
			echo	"</select></td>";
			echo "</tr>";
			
			$j++;
		}
    }
    
    /***************************** STRETCH GOALS ******************************/
    // Tooltip for possible electives?
    // Hover https://www.w3schools.com/bootstrap/bootstrap_tables.asp
    
    // collapsible table
    https://codepen.io/andornagy/pen/gaGBZz
    
?>
