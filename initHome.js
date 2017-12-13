// ***********************************************************************************
//  Author: Joey Brown
//  Class: CSC468, GUI
//  Description: Functions I wrote to set up the home page with dynamic content
// ***********************************************************************************

// TODO: 		- Check assignment sheet for anything else missed.
//				- Save table info
//				- Progress bar to display correct percentage			

//				- Sticky Nav bar on homepage
//				- Sidebar on linked pages
//				- To top of page button
//				- Dropdown for elective courses (?)
//				- Jump to class in sidebar (?)
//				- Toast notification with a save successful/error message(?)

// ***********************************************************************************
// Calls the functions for initializing the home page
// ***********************************************************************************
function initHome() {
	getCurrentUser();
	initializeStudentInfo();
	loadCourses(buildCourseContent);
	progressBarFunc();
	w3_open(); 
}

// ***********************************************************************************
// Calls the functions for initializing the current user's info
// ***********************************************************************************
function initializeStudentInfo() {
	getCurrentUser();
	// ID of tag to locate in the users xml file
	var s_info = ["GPA","FirstName", "LastName", "ID", "completed", "inprogress"];
	// ID of the element on the home.html page
	var docID = ["doc_GPA","doc_User", "doc_completed", "doc_inprogress", "doc_UName"];

	updateStudentInfo(s_info[0], docID[0]);	//GPA
	updateStudentInfo(s_info[3], docID[1]);	//Username (ID)
	updateStudentInfo(s_info[4], docID[2]);	//completed coursed
	updateStudentInfo(s_info[5], docID[3]);	//courses in progress
	updateStudentInfo(s_info[1], docID[4]);	//User name
}


// ***********************************************************************************
// Calls the functions for initializing the course content
// ***********************************************************************************
function initializeCourses() {
	// loadCourses(fillAccordion);
		// not used so far
};


// ***********************************************************************************
// 	Loads class information from courses.xml builds course catalog to fill course cards
//		
// ***TODO: change the file read from or use a different method to fill accordions****
// ***********************************************************************************
function loadCourses(cFunction) {
	getCurrentUser();
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
  	if (this.readyState == 4 && this.status == 200) {
    		cFunction(this);
  	}
	};
	xhttp.open("GET", "./users/" + getCurrentUID() + ".xml", true);
	xhttp.send();
}

// ***********************************************************************************
// Dynamic card creation with course content
// ***********************************************************************************
//		TODO: change function name in this file and home.html
function buildCourseContent(xml) {
  // variables used to fill different cards with related class info
  var accCSC  = "";
  var accMATH = "";
  var accPHYS = "";
  var accENGL = "";
  var accScience = "";
  var accSoc = "";
  var accAH = "";
  var accSAH = "";
  var accFree = "";

  var xmlDoc = xml.responseXML;
  var x = xmlDoc.getElementsByTagName("courses");

  var courseNameLen = getCourseLength(xml);
  var subLen = getSubnameLength(xml);
  var sub = getAllCourseSubnames(xml);
  var arrSubname = fillArray(subLen, xml, getCourseSubnameAt);
  var arrCourseNames = fillArray(courseNameLen, xml, getCourseNameAt);
  var id = [];
  var creditSum = 0;
  
  for (var i = 0; i <courseNameLen; i++) { 
    var check;

    if(arrCourseNames[i].indexOf(' ') === -1){
    	check = arrCourseNames[i];
    } else {
    	check = arrCourseNames[i].split(" ")[0];
    }

    id.push(check+i);
    // Check the course's subname and divide into separate cards
    creditSum += parseInt(getCourseCreditsAt(xml, i));

	  switch(check) {
	    case "CSC" :  
	                accCSC += addTableItem(arrCourseNames[i], id[i], getCourseCreditsAt(xml, i), getCourseGradeAt(xml, i));
	                break;
	    case "MATH" : 
	                accMATH += addTableItem(arrCourseNames[i], id[i], getCourseCreditsAt(xml, i), getCourseGradeAt(xml, i));
	                break;
	    case "PHYS" :
	                accPHYS += addTableItem(arrCourseNames[i], id[i], getCourseCreditsAt(xml, i), getCourseGradeAt(xml, i));
	                break;
	    case "ENGL" : 
	                accENGL += addTableItem(arrCourseNames[i], id[i], getCourseCreditsAt(xml, i), getCourseGradeAt(xml, i));
	                break;
	    case "Science" : 
	                accScience += addTableItem(arrCourseNames[i], id[i], getCourseCreditsAt(xml, i), getCourseGradeAt(xml, i));
	                break;
	    case "Social" : 
	                accSoc += addTableItem(arrCourseNames[i], id[i], getCourseCreditsAt(xml, i), getCourseGradeAt(xml, i)); 
	                break;
	    case "Arts/Humanities" : 
	                accAH += addTableItem(arrCourseNames[i], id[i], getCourseCreditsAt(xml, i), getCourseGradeAt(xml, i)); 
	                break;
	    case "SS/Arts/Hum" : 
	                accSAH += addTableItem(arrCourseNames[i], id[i], getCourseCreditsAt(xml, i), getCourseGradeAt(xml, i)); 
	                break;
	    case "Free" : 
	                accFree += addTableItem(arrCourseNames[i], id[i], getCourseCreditsAt(xml, i), getCourseGradeAt(xml, i)); 
	                break;
	    default: 
	                  console.log(check + " is not recognized.");
	                  break;
	  }
  }
  // Create Basic cards with content filled in
  document.getElementById("cscCard").innerHTML = createTableCard("Computer Science", accCSC, "CSC Footer","CSC");
  document.getElementById("mathCard").innerHTML = createTableCard("Math", accMATH, "Math Footer", "MATH");
  document.getElementById("physCard").innerHTML = createTableCard("Physics", accPHYS, "Physics Footer", "PHYS");
  document.getElementById("englCard").innerHTML = createTableCard("English", accENGL, "English Footer", "ENGL");
  document.getElementById("sciCard").innerHTML = createTableCard("Science", accScience, "Science Footer", "Science");
  document.getElementById("genedCard").innerHTML = createTableCard("Gen-Ed.", accSoc+accAH+accSAH, "Gen-Ed Footer", "GENED");
  document.getElementById("freeCard").innerHTML = createTableCard("Electives", accFree, "Electives Footer", "ELECTIVES");

  // Update grades to current status
  for(var j=0; j < courseNameLen; j++){
  	updateTableGrades(id[j], xml, j);
  }
  //setCourseGradeAt(xml, 10, "D");
}

// ***********************************************************************************
// Course content table for the main page accordion cards.
// ***********************************************************************************
function createTableCard(title, content, footText, id) {
  return "<div class=\"w3-card-4\">" +
            "<button class=\"card_header w3-button w3-block w3-container\" onclick=\"myAccFunc(\'" + id + "\')\">" +
              "<h1>" + title + "</h1>" +
            "</button>" +
            "<div id=\"" + id + "\"class=\"w3-container w3-hide w3-show\">" +
              buildTable(content) +
            "</div>" +
              addFooter(footText) +
        "</div>";
}

// ***********************************************************************************
// Course content for the main page cards. (Table Version Work in Progress)
// ***********************************************************************************
function addTableItem(name, id, credits, grade) {
  return "<tr style=\"background-color: " + setTableColor("sel_"+id, grade) + "\"id=\"" + id + "\">" +
			      "<td class=\"course_name\">" + name + "</td>" +
			      "<td class=\"credits\">" + credits + "</td>" +
			     "<td>" +
			        "<select id=\"sel_" + id + "\" class=\"grades\">" +
			          // "<option value=\"NA\"> --- </option>" +
			          // "<option value=\"inprog\"> In Progress </option>" +
			          // "<option value=\"A\"> A </option>" +
			          // "<option value=\"B\"> B </option>" +
			          // "<option value=\"C\"> C </option>" +
			          // "<option value=\"D\"> D </option>" +
			          // "<option value=\"F\" selected=\"F\"> F </option>" +
			          setDropdownContent(grade) +
			        "</select>" +
			      "</td>" +
			    "</tr>";
}

// ***********************************************************************************
// Adds optional text to the bottom of the course content cards.
// ***********************************************************************************
function addFooter(footText){
  return "<footer class=\"card_footer w3-container\">" +
              "<h5>" + footText + "</h5>" +
            "</footer>";
}

// ***********************************************************************************
// Creates an entire table
// ***********************************************************************************
function buildTable(t_row) {
	return "<div class=\"container\">" +
		  "<table class=\"w3-table w3-striped\">" +
		    "<tr>" +
		      "<th>Course</th>" +
		      "<th>Credits</th>" +
		      "<th>Grade</th>" +
		   " </tr>" +
		   	 t_row + 	// table row
		   "</table>" +
		"</div>";
}

// ***********************************************************************************
// Updates table grade info. First used after content is loaded in buildCourseContent()
// Initializing with the correctly selected works better w/ setDropdownContent()
// ***********************************************************************************
function updateTableGrades(sel_id, xml, i) {
	var val = getCourseGradeAt(xml, i);
	if(val === ""){
		val = "NA";
	}
	var sel = document.getElementById("sel_"+sel_id);
  var opts = sel.options;

	// set selected value
	for (var opt, j = 0; opt = opts[j]; j++) {
	    if (opt.value == val) {
	      // sel.selectedIndex = j;
	      sel.options[j].selected = true;
	      return;
    	}
	}	
	
	// Set table color corresponding to grade
	setTableColor(sel_id, val);
}

// ***********************************************************************************
// Updates table colors based on the availability of the course.
// ***********************************************************************************
function setTableColor(sel_id, grade) {
	// find the grade dropdown selection value and change the color
	var tClr;
	
	switch(grade){
		case "inprog":
			tClr = "#ffffcc"; // yellow
			break;
		case "A":
			// break;
		case "B":
			// break;
		case "EX":
		case "C":
			tClr = "#99ff99";	// green
			break;
		case "D":
			// break;
		case "F":
			tClr = "#ff6666";	// red
			break;
		default:
			tClr = "#EEEDEB";
	}
	
	return tClr;
}


// ***********************************************************************************
// Creates the dropdown list and selects the proper item
// ***********************************************************************************
function setDropdownContent(grade){
	
	var na = "<option value=\"NA\"> --- </option>";
  var ip = "<option value=\"inprog\"> In Progress </option>";
  var a = "<option value=\"A\"> A </option>";
  var b = "<option value=\"B\"> B </option>";
  var c = "<option value=\"C\"> C </option>";
  var d = "<option value=\"D\"> D </option>";
  var f = "<option value=\"F\"> F </option>";
  var x = "<option value=\"EX\"> EX </option>";
	switch(grade){
		case "inprogress":
			ip = "<option value=\"inprog\" selected> In Progress </option>";
			break;
		case "A":
			a = "<option value=\"A\" selected> A </option>";
			break;
		case "B":
			b = "<option value=\"B\" selected> B </option>";
			break;
		case "C":
			c = "<option value=\"C\" selected> C </option>";
			break;
		case "D":
			d = "<option value=\"D\" selected> D </option>";
			break;
		case "F":
			f = "<option value=\"F\" selected> F </option>";
			break;
		case "EX":
			x = "<option value=\"EX\" selected> EX </option>";
			break;
		default:
			na = "<option value=\"NA\" selected> --- </option>";
			break;
	}

	return na + ip + a + b + c + d + f + x;
}

// ***********************************************************************************
// Fills an array with the contents of another
// ***********************************************************************************
function fillArray(length, xml, getFunctionAt) {
	var x = [];
	for(var i=0; i < length; i++){
		x.push(getFunctionAt(xml, i));
	}
	return x;
}
