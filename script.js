// *****************************************************
//  Author: Joey Brown
//  Class: CSC468, GUI
//  Description: This JavaScript file holds all the functionality
//   of the page items (like sidebars and dropdowns)
// *****************************************************


// Behavior for opening the sidebar
function w3_open() {
  document.getElementById("main").style.marginLeft = "25%";
  document.getElementById("mySidebar").style.width = "25%";
  document.getElementById("mySidebar").style.display = "block";
  // document.getElementById("openNav").style.display = 'none';
}

// Behavior for closing the sidebar
function w3_close() {
  document.getElementById("main").style.marginLeft = "0%";
  document.getElementById("mySidebar").style.display = "none";
  // document.getElementById("openNav").style.display = "inline-block";
}

// Behavior for the accordians
function myAccFunc(id) {
  var x = document.getElementById(id);
	if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
        x.previousElementSibling.className += " w3-blue";
    } else { 
        x.className = x.className.replace(" w3-show", "");
        x.previousElementSibling.className = 
        x.previousElementSibling.className.replace(" w3-blue", "");
    }
}

// Sidebar progress bar
function progressBarFunc() {
  getCurrentUser();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var progPcnt = (parseInt(getCoursesCompleted(this)) / 119) * 100;
      document.getElementById("myProgBar").innerHTML = progPcnt.toFixed(1) + "%";
      // document.getElementById("myProgBar").style.width = progPcnt.toFixed(1) + "%";
      // var elem = document.getElementById("myProgBar"); 
      // var width = getCoursesCompleted(this);
      // console.log(getCoursesCompleted(this));
      // var id = setInterval(frame, 10);
      // function frame() {
      //     if (width >= 100) {
      //         clearInterval(id);
      //     } else {
      //         width++; 
      //         elem.style.width = width + '%'; 
      //         elem.innerHTML = width * 1 + '%';
      //     }
      // }
    }
  };
  xhttp.open("GET", "./users/" + getCurrentUID() + ".xml", true);
  xhttp.send();
}

// *****************************************************
// ****************START OF INITIALIZE******************
// *****************************************************
// Dynamic card creation with newstudent.xml
function initializeCards(xml) {
  // variables used to fill different cards with related class info
  var accCSC  = "";
  var accMATH = "";
  var accPHYS = "";
  var accENGL = "";
  var xmlDoc = xml.responseXML;
  var x = xmlDoc.getElementsByTagName("course");
  // console.log(getInfo(xml, "number")[0].childNodes[0].nodeValue);
  console.log(xmlDoc.getElementsByTagName("courses"));
  for (var i = 0; i <x.length; i++) { 
    var classPrefix = getInfo(xml, "prefix")[i].firstChild.nodeValue;
    console.log(classPrefix);
    var classNum = getInfo(xml, "number")[i].childNodes[0].nodeValue;
    var classCredits = getInfo(xml, "credits")[i].childNodes[0].nodeValue;
    var courseID = classPrefix+classNum;
    var courseDesc = "NaNaNa";
    var name = classPrefix + " " + classNum;

    // Add every class with same prefix & isactive = yes
    //    Three ='s to check for equal value and equal type
    switch(classPrefix) {
      case "CSC" :  
                  accCSC += addAccordion(name, courseID, courseDesc, classCredits);
                  break;
      case "MATH" : 
                  accMATH += addAccordion(name, courseID, courseDesc, classCredits);
                  break;
      case "PHYS" :
                  accPHYS += addAccordion(name, courseID, courseDesc, classCredits);
                  break;
      case "ENGL" : 
                  accENGL += addAccordion(name, courseID, courseDesc, classCredits);  
                  break;
      default: 
                    console.log(classPrefix + " is not recognized.");
    }
  }
  document.getElementById("cscCard").innerHTML = addCard("Computer Science", accCSC, "Haxorman","CSC");
  document.getElementById("mathCard").innerHTML = addCard("Math", accMATH, "Math sux", "MATH");
  document.getElementById("physCard").innerHTML = addCard("Physics", accPHYS, "Calculus sux", "PHYS");
  document.getElementById("englCard").innerHTML = addCard("English", accENGL, "No one reads anymore", "ENGL");
}


// // Dynamic card creation with course content
// function fillAccordion(xml) {
//   // variables used to fill different cards with related class info
//   var accCSC  = "";
//   var accMATH = "";
//   var accPHYS = "";
//   var accENGL = "";
//   var i;
//   var xmlDoc = xml.responseXML;
//   var x = xmlDoc.getElementsByTagName("course");
  
//   for (i = 0; i <x.length; i++) { 
//     // Create variable to check if class is active
//     var attr = xmlDoc.getElementsByTagName("course")[0].attributes;
//     var txt = attr.getNamedItem("isactive").nodeValue;
//     var classPrefix = x[i].getElementsByTagName("prefix")[0].childNodes[0].nodeValue;
//     var classNum = x[i].getElementsByTagName("number")[0].childNodes[0].nodeValue;
//     var classCredits = x[i].getElementsByTagName("credits")[0].childNodes[0].nodeValue;
//     var courseID = classPrefix+classNum;
//     var courseDesc = getCourseDescription(xml, courseID)
//     var name = classPrefix + " " + classNum;

//     // Add every class with same prefix & isactive = yes
//     //    Three ='s to check for equal value and equal type
//     if (txt === "yes") {
//       switch(classPrefix) {
//         case "CSC" :  
//                     accCSC += addAccordion(name, courseID, courseDesc, classCredits);
//                     break;
//         case "MATH" : 
//                     accMATH += addAccordion(name, courseID, courseDesc, classCredits);
//                     break;
//         case "PHYS" :
//                     accPHYS += addAccordion(name, courseID, courseDesc, classCredits);
//                     break;
//         case "ENGL" : 
//                     accENGL += addAccordion(name, courseID, courseDesc, classCredits);  
//                     break;
//         default: 
//                       console.log(classPrefix + " is not recognized.");
//       }
//     }
//   }
//   document.getElementById("cscCard").innerHTML = addCard("Computer Science", accCSC, "Haxorman","CSC");
//   document.getElementById("mathCard").innerHTML = addCard("Math", accMATH, "Math sux", "MATH");
//   document.getElementById("physCard").innerHTML = addCard("Physics", accPHYS, "Calculus sux", "PHYS");
//   document.getElementById("englCard").innerHTML = addCard("English", accENGL, "No one reads anymore", "ENGL");
// }

// Fills the sidebar with the same information as the main page
function fillSideBar(xml){
  // // variables used to fill different cards with related class info
  // var accCSC  = "";
  // var accMATH = "";
  // var accPHYS = "";
  // var accENGL = "";
  // var i;
  // var xmlDoc = xml.responseXML;
  // var x = xmlDoc.getElementsByTagName("course");
  
  // for (i = 0; i <x.length; i++) { 
  //   // Create variable to check if class is active
  //   var attr = xmlDoc.getElementsByTagName("course")[0].attributes;
  //   var txt = attr.getNamedItem("isactive").nodeValue;
  //   // Variables to store course information
  //   var classPrefix = x[i].getElementsByTagName("prefix")[0].childNodes[0].nodeValue;
  //   var classNum = x[i].getElementsByTagName("number")[0].childNodes[0].nodeValue;
  //   var courseID = classPrefix+classNum+"_sb";
  //   var name = classPrefix + " " + classNum;

  //   // Add every class with same prefix & isactive = yes
  //   //    Three ='s to check for equal value and equal type
  //   if (txt === "yes") {
  //     switch(classPrefix) {
  //       case "CSC" :  
  //                   accCSC += addSidebarContent(name, courseID);
  //                   break;
  //       case "MATH" : 
  //                   accMATH += addSidebarContent(name, courseID);
  //                   break;
  //       case "PHYS" :
  //                   accPHYS += addSidebarContent(name, courseID);
  //                   break;
  //       case "ENGL" : 
  //                   accENGL += addSidebarContent(name, courseID);  
  //                   break;
  //       default: 
  //                     console.log(classPrefix + " is not recognized.");
  //     }
  //   }
  // }
  //  document.getElementById("cscAcc").innerHTML = addSidebarContent(accCSC, "cscSBar");
  //  document.getElementById("mathAcc").innerHTML = addSidebarContent(accMATH, "mathSBar");
  //  document.getElementById("physAcc").innerHTML = addSidebarContent(accPHYS, "physSBar");
  //  document.getElementById("englAcc").innerHTML = addSidebarContent(accENGL, "englSBar");
}

// uses PHP to load parsed XML data of the user's info
function loadDoc() {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("stuID").innerHTML = this.responseText;
      checkCookie(this.responseText);
    }
  };
  xmlhttp.open("GET", "home.php", true);
  xmlhttp.send();
}



// // ***********************************************************************************
// //  Set the cookie for logged in user
// // ***********************************************************************************
// function setCookie(cname,cvalue,exdays) {
//     var d = new Date();
//     d.setTime(d.getTime() + (exdays*24*60*60*1000));
//     var expires = "expires=" + d.toGMTString();
//     document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
// }

// // ***********************************************************************************
// //  Get the cookie for logged in user
// // ***********************************************************************************
// function getCookie(cname) {
//     var name = cname + "=";
//     var decodedCookie = decodeURIComponent(document.cookie);
//     var ca = decodedCookie.split(';');
//     for(var i = 0; i < ca.length; i++) {
//         var c = ca[i];
//         while (c.charAt(0) == ' ') {
//             c = c.substring(1);
//         }
//         if (c.indexOf(name) == 0) {
//             return c.substring(name.length, c.length);
//         }
//     }
//     return "";
// }

// // ***********************************************************************************
// //  Check the cookie of the logged in user
// // ***********************************************************************************
// function checkCookie(str) {
//     var user=getCookie("username");
//     if (user != "") {
//         // alert("Welcome again " + user);
//         console.log("User: " + getCookie("username"));
//     } else {
//        // user = prompt("Please enter your name:","");
//        user = str;
//        if (user != "" && user != null) {
//            setCookie("username", user, 30);
//        }
//     }
// }












// // Loads class information from courses.xml
// //   builds course catalog to fill course cards
// function loadCourses(cFunction) {
//   var xhttp = new XMLHttpRequest();
//   xhttp.onreadystatechange = function() {
//     if (this.readyState == 4 && this.status == 200) {
//       cFunction(this);
//     }
//   };
//   xhttp.open("GET", "courses.xml", true);
//   // xhttp.open("GET", "./users/7110007.xml", true);
//   xhttp.send();
// }

// Final version of the dynamic card creator.
//    Creates a card for classes with the same prefix.
function addCard(title, content, footText, id) {
  return "<div class=\"w3-card-4\">" +
            "<header class=\"card_header w3-button w3-block w3-container\" onclick=\"myAccFunc(\'" + id + "\')\">" +
              "<h1>" + title + "</h1>" +
            "</header>" +
            "<div id=\"" + id + "\"class=\"w3-container w3-hide\">" +
              content +
            "</div>" +
              addFooter(footText) +
            "</div>";
}

// May be an isssue here **FIX**
function addSidebarButton(title, content, id) {
  return "<button class=\"w3-button w3-block w3-left-align\" onclick=\"myAccFunc(\'" + id + "\')\">" +
      title + " <i class=\"fa fa-caret-down\"></i>" +
    "</button>" +
    "<div id=\"" + id + "\" class=\"w3-hide w3-card-2\">" +
      // "<a href=\"#\" class=\"w3-bar-item w3-button\">MATH 125</a>" +
      content +
    "</div>";
}

function addSidebarContent(title, id) {
  return "<a id=\"" + id + "\" href=\"#\" class=\"w3-bar-item w3-button\">" + title + "</a>";
}

// // Course content for the main page cards.
// function addAccordion(name, id, description, credits) {
//   return "<button onclick=\"myAccFunc(\'" + id + "\')\" class=\"accordion w3-button w3-block w3-left-align\">" + 
//             name + " <i class=\"fa fa-caret-down\"></i>" + 
//             "<span class=\"w3-right\">" +
//               "<a href=\"#\" class=\"w3-bar-item w3-button w3-right course_credits\"><span>Credits: " + credits + "</span></a>" +
//           "</span></button>" + 
//           "<div id=\"" + id + "\" class=\"w3-hide\">" + 
//             "<a href=\"#\" class=\"content w3-button w3-block w3-left-align\" style=\"white-space:normal;\" >" + 
//             description + "</a>" + 
//           "</div>";
// }

// Optional footer content for the course cards on the main page.
// function addFooter(footText){
//   return "<footer class=\"card_footer w3-container\">" +
//               "<h5>" + footText + "</h5>" +
//             "</footer>";
// }

// Loads the course description for use in the main page course cards.
function getCourseDescription(xml, courseID) {
  // classID = "prefix" + "number" from courses.xml
  var i;
  var xmlDoc = xml.responseXML;
  var x = xmlDoc.getElementsByTagName("course");
  var courseDesc = "";
  for (i = 0; i <x.length; i++) { 
    var c_id =
    x[i].getElementsByTagName("prefix")[0].childNodes[0].nodeValue +
    x[i].getElementsByTagName("number")[0].childNodes[0].nodeValue;
    
    if (courseID === c_id) {
      courseDesc = x[i].getElementsByTagName("description")[0].childNodes[0].nodeValue;
      break;
    }
  }
  // console.log(courseID);
  // document.getElementById(courseID).innerHTML = courseDesc;
  return courseDesc;
}

// (Optional) Separate the course cards into sections based on Freshman, Sophomore, etc.
function addCardSection(title, id) {
  return "";
}

// Inserts credit information into the accordions
function addCredits(credits) {
  return "<span class=\"w3-right\">" +
    "<a href=\"#\" class=\"w3-bar-item w3-button w3-right\"><span>Credits: </span>" + credits + "</a>" + 
  "</span>";
}
//*************************************************************


// // Loads student information from newstudent.xml
// function loadNewStudent(cFunction) {
//   var xhttp = new XMLHttpRequest();
//   xhttp.onreadystatechange = function() {
//     if (this.readyState == 4 && this.status == 200) {
//       cFunction(this);
//     }
//   };
//   // xhttp.open("GET", "newstudent.xml", true);
//   xhttp.open("GET", "./users/7110007.xml", true);
//   xhttp.send();
// }

// function parseNewStudentXML(xml){
//  // variables used to fill different cards with related class info
//   var xmlDoc = xml.responseXML;
//   var courses = xmlDoc.getElementsByTagName("courses");
//   var subject = xmlDoc.getElementsByTagName("subject");
//   var subname = xmlDoc.getElementsByTagName("subname");
//   var course = xmlDoc.getElementsByTagName("course");
//   var prefix = xmlDoc.getElementsByTagName("prefix");
//   // var prefix = getInfo(xml, "prefix")[0].childNodes[0].nodeValue;
//   // var number = getInfo(xml, "number")[0].childNodes[0].nodeValue;
  
//   // console.log(courses);
//   // console.log(subject);
//   // console.log(subname);
//   // console.log(course[0].childNodes[1].childNodes[0].nodeValue);
//   // console.log(prefix);
//   for (var i = 0; i < course.length; i++) {
//     console.log(course[i].childNodes[1].childNodes[0].nodeValue);
//   }
// }

function parseNewStudentXML_PHP() {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
    }
  };
  xmlhttp.open("GET", "getCourses.php", true);
  xmlhttp.send();
}

function getInfo(xml, str) {
  var xmlDoc = xml.responseXML;
  return xmlDoc.getElementsByTagName(str);
}

// use getInfo(xml, "gpa") to update gpa
// TODO: create a php file that returns user session's GPA
function loadGPA() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById('GPA').innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "getGPA.php", true);
  xhttp.send();
}

function loadCompleted() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById('completedCredits').innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "getCompleted.php", true);
  xhttp.send();
}

function loadInProgress() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById('inProgress').innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "getInProgress.php", true);
  xhttp.send();
}

function checkLog() {
  var c = document.getElementsByClassName('course_credits');
  console.log(c[0].firstChild.lastChild.nodeValue);
}
