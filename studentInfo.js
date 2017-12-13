// ***********************************************************************************
//  Author: Joey Brown, Peter Yamaguchi
//  Class: CSC468, GUI
//  Description: Functions I wrote to get student data from the XML files.
// ***********************************************************************************

// ***********************************************************************************
// Loads student information from <student id>.xml in the home page
// ***********************************************************************************
function updateStudentInfo(str, id) {
  getCurrentUser();
  var xhttp = new XMLHttpRequest();
  var user = getCurrentUser();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById(id).innerHTML = parseStudentXML(this, str);
    }
  };
  xhttp.open("GET", "./users/"+ getCurrentUID() + ".xml", true);
  xhttp.send();
}

// ***********************************************************************************
// Calls the functions for testing
// ***********************************************************************************
function parseStudentXML(xml, str){
  var data;
  switch(str){
    case "GPA":
      data = getStudentGPA(xml);
      break;
    case "FirstName":
      data = getFirstName(xml);
      break;
    case "LastName":
      data = getLastName(xml);
      break;
    case "ID":
      data = getStudentID(xml);
      break;
    case "completed":
      data = getCoursesCompleted(xml);
      break;
    case "inprogress":
      data = getInProgress(xml);
      break;
    default:
      console.log("Error: " + str + " doesn't exist.");
      break;
  }

  return data;
}

// ***********************************************************************************
// Returns the data of a single level in the xml file
// ***********************************************************************************
function getData(xml, str) {
  var xmlDoc = xml.responseXML;
  var x = xmlDoc.getElementsByTagName(str)[0].lastChild.nodeValue;
  return x;
}

// ***********************************************************************************
// Returns First name of the logged in user
// ***********************************************************************************
function getFirstName(xml) { return getData(xml, "first"); }

// ***********************************************************************************
// returns the last name of the logged in user
// ***********************************************************************************
function getLastName(xml) { return getData(xml, "last"); }

// ***********************************************************************************
// Returns the current user's student ID number
// ***********************************************************************************
function getStudentID(xml) { return getData(xml, "studentid")};

// ***********************************************************************************
// Returns the current user's GPA
// ***********************************************************************************
function getStudentGPA(xml) { return getData(xml,"gpa"); }

// ***********************************************************************************
// Returns the current user's courses completed
// ***********************************************************************************
function getCoursesCompleted(xml) { return getData(xml, "completed"); }

// ***********************************************************************************
// Returns the current user's courses completed
// ***********************************************************************************
function getInProgress(xml) { return getData(xml, "inprogress"); }

// ***********************************************************************************
// Returns the course name
// ***********************************************************************************
function getCourseNameAt(xml, i) {
  var xmlDoc = xml.responseXML;
  var course = xmlDoc.getElementsByTagName("course");
  return course[i].childNodes[1].childNodes[0].nodeValue;
}

// ***********************************************************************************
// Returns all course names as a string
// ***********************************************************************************
function getAllCourseNames(xml) {
  var xmlDoc = xml.responseXML;
  var course = xmlDoc.getElementsByTagName("course");
  var courseList = [];
  for (var i = 0; i < course.length; i++) {
    courseList.push(getCourseNameAt(xml, i));
  }
  return courseList;
}

// ***********************************************************************************
// Returns the number of required courses in the <student id>.xml file
// ***********************************************************************************
function getCourseLength(xml) {
  var xmlDoc = xml.responseXML;
  return xmlDoc.getElementsByTagName("course").length;
}

// ***********************************************************************************
// Returns the subname of the courses
// ***********************************************************************************
function getCourseSubnameAt(xml, i) {
  var xmlDoc = xml.responseXML;
  return xmlDoc.getElementsByTagName("subname")[i].childNodes[0].nodeValue;
}

// ***********************************************************************************
// Returns all course names as a string
// ***********************************************************************************
function getAllCourseSubnames(xml) {
  var xmlDoc = xml.responseXML;
  var sub = xmlDoc.getElementsByTagName("subname");
  var subList = [];
  for (var i = 0; i < sub.length; i++) {
    subList.push(getCourseSubnameAt(xml, i));
  }
  return subList;
}

// ***********************************************************************************
// Returns the number of required courses in the <student id>.xml file
// ***********************************************************************************
function getSubnameLength(xml) {
  var xmlDoc = xml.responseXML;
  return xmlDoc.getElementsByTagName("subname").length;
}

// ***********************************************************************************
// Returns the course name
// ***********************************************************************************
function getCourseCreditsAt(xml, i) {
  var xmlDoc = xml.responseXML;
  var credits = xmlDoc.getElementsByTagName("credits");
  return credits[i].childNodes[0].nodeValue;
}

// ***********************************************************************************
// Returns the course grade
// ***********************************************************************************
function getCourseGradeAt(xml, i) {
  var xmlDoc = xml.responseXML;
  var grade = xmlDoc.getElementsByTagName("grade");
  var str = "";
  if(grade[i].childNodes.length === 1){
    str = grade[i].innerHTML;
  } else {
    str = "NA";
  }
  return str;
}

// ***********************************************************************************
// Sets the course grade for a single class
// ***********************************************************************************
// function setCourseGradeAt(xml, i, newGrade){
//   var xmlDoc = xml.responseXML;
//   var g = xmlDoc.getElementsByTagName("grade");
//   //g[i].innerHTML = newGrade;
//   console.log(g[i].innerHTML);
// }



// ***********************************************************************************
// ***********************************************************************************
//          PHP and AJAX below
// to use when knowing the session information is necessary.
// ***********************************************************************************
// ***********************************************************************************


// ***********************************************************************************
// Returns the current session login ID information
// ***********************************************************************************
function updateFunction(cFunction){
  var str;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      cFunction(this.responseText);
    }
  };
  xmlhttp.open("GET", getCurrentUID(), true);
  xmlhttp.send();
}

// ***********************************************************************************
// Returns the current user's student ID number 
//  TODO: change the functionality to something other than console.log()
// ***********************************************************************************
function getCurrentUser() {
  var str;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      // checkCookie(this.responseText);
      setCookie("username", this.responseText, 0);
    }
  };
  xmlhttp.open("GET", "getSessionID.php", true);
  xmlhttp.send();
}


function saveGradeInfo(){
  var nodeList = document.getElementsByClassName("grades");
  var c_list = document.getElementsByClassName("course_name");
  var txt = [];
  var str = "";

  console.log(c_list[0].firstChild.nodeValue);
  console.log(nodeList[0].options[nodeList[0].selectedIndex].innerHTML);
  for(var i=0; i< nodeList.length; i++){
    txt.push(c_list[i].firstChild.nodeValue);
    txt.push("=");
    txt.push(nodeList[i].options[nodeList[i].selectedIndex].value);
    str += c_list[i].firstChild.nodeValue + "=" + nodeList[i].options[nodeList[i].selectedIndex].value + ',';
    console.log(txt[i]);  

  }
    console.log(str);
    t(str);
    
}

function t(str){

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    	alert("Successfully Updated Student Information!");
      	window.location.reload(true);
      
      //buildCourseContent(this.responseXML);
    }
  };
  xmlhttp.open("POST", "updateStudentInfo.php", false);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send("data="+str);
  

}
