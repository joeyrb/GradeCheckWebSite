

// ***********************************************************************************
//  Set the cookie for logged in user
// ***********************************************************************************
function setCookie(cname,cvalue,exdays) {
    var d = new Date();
    // d.setTime(d.getTime() + (exdays*24*60*60*1000));
    // var expires = "expires=" + d.toGMTString();
    // console.log(expires);
    // document.cookie = cname + "=" + cvalue + ";" + expires + ";";
    document.cookie = cname + "=" + cvalue + ";";
}

// ***********************************************************************************
//  Get the cookie for logged in user
// ***********************************************************************************
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

// ***********************************************************************************
//  Check the cookie of the logged in user
// ***********************************************************************************
function checkCookie(str) {
    var user=getCookie("username");
    if (user != "") {
        console.log("User: " + getCurrentUID());

    }
    else if(user == "") {
        setCookie("username", str, 30);
    }
    else {
       // user = prompt("Please enter your name:","");
       user = str;
       if (user != "" && user != null) {
           setCookie("username", user, 30);
       }
    }
}


// ***********************************************************************************
// Returns the ID of the current user from the cookies
// ***********************************************************************************
function getCurrentUID() {
    return getCookie("username");
}

