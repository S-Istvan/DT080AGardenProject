function openNav() 
{
    if (window.matchMedia("(min-width: 500px)").matches) {
        /* the viewport is at least 500 pixels wide */
        document.getElementById("mySidenav").style.width = "10%";
        document.getElementById("mySidenav").style.height = "100%";
        document.getElementById("main").style.marginLeft = "10%";
      } else {
        /* the viewport is less than 500 pixels wide */
        document.getElementById("mySidenav").style.width = "100%";
        document.getElementById("mySidenav").style.height = "25%";
      }
}
function closeNav()
{
    document.getElementById("mySidenav").style.width = "0";
    document.getElementById("main").style.marginLeft= "0";
}
function openChartNav() {
    document.getElementById("mySidenav").style.width = "10%";
}

function closeChartNav() 
{
    document.getElementById("mySidenav").style.width = "0";
}

function activateLights()
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            document.getElementById("actLightPara").style.color = "white"
            document.getElementById("actLightPara").style.visibility = "visible"
            document.getElementById("actLightPara").innerHTML = this.responseText;
            document.getElementById("deactLightPara").style.visibility = "hidden";
            actLightResponse();
        }
        else if (this.readyState == 1)
        {
            document.getElementById("actLightPara").style.color = "white"
            document.getElementById("actLightPara").style.visibility ="visible"
            document.getElementById("actLightPara").innerHTML = "Processing Request";
        }
        else
        {
            document.getElementById("actLightPara").style.visibility = "visible"
            document.getElementById("actLightPara").style.color = "red"
            document.getElementById("actLightPara").innerHTML = "Failed"
        }
    };
    xhttp.open("POST", "http://192.168.0.59", true);

    xhttp.send("activateLights/");
}
function actLightResponse()
{
    document.getElementById('backImgActShadow').style.animationName = "unfadeShadow"
    document.getElementById('backImgActShadow').style.animationDuration = "8s"
    document.getElementById('backImgActShadow').style.animationTimingFunction = "ease-in-out"
    document.getElementById('backImgActShadow').style.animation = "unfadeShadow 8s forwards"
    stopRaining = setTimeout(reverseShadow, 8000); 
}
function reverseShadow()
{
    document.getElementById('backImgActShadow').style.animationName = ""
    document.getElementById('backImgActShadow').style.animationDuration = ""
    document.getElementById('backImgActShadow').style.animationTimingFunction = ""
}

function deactivateLights()
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            document.getElementById("deactLightPara").style.color = "white";
            document.getElementById("deactLightPara").innerHTML = this.responseText;
            document.getElementById("deactLightPara").style.visibility = "visible";
            document.getElementById("actLightPara").style.visibility = "hidden";
            deActLightResponse();
        }
        else if (this.readyState == 1)
        {
            document.getElementById("deactLightPara").style.color = "white"
            document.getElementById("deactLightPara").style.visibility ="visible"
            document.getElementById("deactLightPara").innerHTML = "Processing Request";
        }
        else
        {
            document.getElementById("deactLightPara").style.visibility = "visible";
            document.getElementById("deactLightPara").style.color = "red"
            document.getElementById("deactLightPara").innerHTML = "Failed"
        }
    };
    xhttp.open("POST", "http://192.168.0.59/", true);
    xhttp.send("deactivateLights/");
}
function deActLightResponse()
{
    document.getElementById('backImgActDarken').style.animationName = "unfadeDarken"
    document.getElementById('backImgActDarken').style.animationDuration = "8s"
    document.getElementById('backImgActDarken').style.animationTimingFunction = "ease-in-out"
    document.getElementById('backImgActDarken').style.animation = "unfadeDarken 8s forwards"
    stopRaining = setTimeout(reverseDarken, 8000); 
}
function reverseDarken()
{
    document.getElementById('backImgActDarken').style.animationName = ""
    document.getElementById('backImgActDarken').style.animationDuration = ""
    document.getElementById('backImgActDarken').style.animationTimingFunction = ""
}

function activatePump()
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200)
        {
            document.getElementById("actPumpPara").style.color = "white"
            document.getElementById("actPumpPara").style.visibility ="visible"
            document.getElementById("actPumpPara").innerHTML = this.responseText;
            actPumpResponse();
        }
        else if (this.readyState == 1)
        {
            document.getElementById("actPumpPara").style.color = "white"
            document.getElementById("actPumpPara").style.visibility ="visible"
            document.getElementById("actPumpPara").innerHTML = "Processing Request";
        }
        else
        {
            document.getElementById("actPumpPara").style.visibility ="visible"
            document.getElementById("actPumpPara").style.color = "red"
            document.getElementById("actPumpPara").innerHTML = "Failed"
        }
    };
    xhttp.open("POST", "http://192.168.0.59/", true);
    xhttp.send("activatePump/");
}
function actPumpResponse()
{
    var stopRaining;
    document.getElementById("backImgActAnim").style.opacity = "100"
    document.getElementById("backImgActAnim").style.visibility = "visible"
    stopRaining = setTimeout(stopRainAnim, 15000); 
}
function stopRainAnim()
{
    document.getElementById("backImgActAnim").style.opacity = "0"
}
function setMaxTemp()
{
    var xhttp = new XMLHttpRequest();
    var maxTemp = document.getElementById("maxSlider").value;
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200)
        {
            document.getElementById("maxTempSlideResponse").style.color = "white"
            document.getElementById("maxTempSlideResponse").style.visibility ="visible"
            document.getElementById("maxTempSlideResponse").innerHTML = this.responseText;
        }
        else if (this.readyState == 1)
        {
            document.getElementById("maxTempSlideResponse").style.color = "white"
            document.getElementById("maxTempSlideResponse").style.visibility ="visible"
            document.getElementById("maxTempSlideResponse").innerHTML = "Processing Request";
        }
        else
        {
            document.getElementById("maxTempSlideResponse").style.visibility ="visible"
            document.getElementById("maxTempSlideResponse").style.color = "red"
            document.getElementById("maxTempSlideResponse").innerHTML = "Failed"
        }
    };
    xhttp.open("POST", "http://192.168.0.59", true);
    xhttp.send("setMaxTemp/"+maxTemp+"/");
}
function setMinTemp()
{
    var xhttp = new XMLHttpRequest();
    var minTemp = document.getElementById("minSlider").value;
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200)
        {
            document.getElementById("minTempSlideResponse").style.color = "white"
            document.getElementById("minTempSlideResponse").style.visibility ="visible"
            document.getElementById("minTempSlideResponse").innerHTML = this.responseText;
        }
        else if (this.readyState == 1)
        {
            document.getElementById("minTempSlideResponse").style.color = "white"
            document.getElementById("minTempSlideResponse").style.visibility ="visible"
            document.getElementById("minTempSlideResponse").innerHTML = "Processing Request";
        }
        else
        {
            document.getElementById("minTempSlideResponse").style.visibility ="visible"
            document.getElementById("minTempSlideResponse").style.color = "red"
            document.getElementById("minTempSlideResponse").innerHTML = "Failed"
        }
    };
    xhttp.open("POST", "http://192.168.0.59/", true);
    xhttp.send("setMinTemp/"+minTemp+"/");
}
function moveServoUp()
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            document.getElementById("moveServoUpPara").style.color = "white"
            document.getElementById("moveServoUpPara").style.visibility = "visible"
            document.getElementById("moveServoUpPara").innerHTML = this.responseText;
            document.getElementById("moveServoDownPara").style.visibility = "hidden";
         //   actLightResponse();
        }
        else if (this.readyState == 1)
        {
            document.getElementById("moveServoUpPara").style.color = "white"
            document.getElementById("moveServoUpPara").style.visibility ="visible"
            document.getElementById("moveServoUpPara").innerHTML = "Processing Request";
        }
        else
        {
            document.getElementById("moveServoUpPara").style.visibility = "visible"
            document.getElementById("moveServoUpPara").style.color = "red"
            document.getElementById("moveServoUpPara").innerHTML = "Failed"
        }
    };
    xhttp.open("POST", "http://192.168.0.58/", true);
    xhttp.send("moveCameraUp/");
}

function moveServoDown()
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            document.getElementById("moveServoDownPara").style.color = "white"
            document.getElementById("moveServoDownPara").style.visibility = "visible"
            document.getElementById("moveServoDownPara").innerHTML = this.responseText;
            document.getElementById("moveServoUpPara").style.visibility = "hidden";
            actLightResponse();
        }
        else if (this.readyState == 1)
        {
            document.getElementById("moveServoDownPara").style.color = "white"
            document.getElementById("moveServoDownPara").style.visibility ="visible"
            document.getElementById("moveServoDownPara").innerHTML = "Processing Request";
        }
        else
        {
            document.getElementById("moveServoDownPara").style.visibility = "visible"
            document.getElementById("moveServoDownPara").style.color = "red"
            document.getElementById("moveServoDownPara").innerHTML = "Failed"
        }
    };
    xhttp.open("POST", "http://192.168.0.58", true);
    xhttp.send("moveCameraDown/");
}
function actLightIconMOver()
{
    document.getElementById("actLightIcon").style.filter ="invert(100%)";
}
function actLightIconMOut()
{
    document.getElementById("actLightIcon").style.filter ="invert(0%)";
}
function deactLightIconMOver()
{
    document.getElementById("deactLightIcon").style.filter ="invert(100%)";
}
function deactLightIconMOut()
{
    document.getElementById("deactLightIcon").style.filter ="invert(0%)";
}
function actPumpIconMOver()
{
    document.getElementById("actPumpIcon").style.filter ="invert(100%)";
}
function actPumpIconMOut()
{
    document.getElementById("actPumpIcon").style.filter ="invert(0%)";
}
/*function actCameraUpIconMOver()
{
    document.getElementById("camUpIcon").style.filter ="invert(100%)";
}
function actCameraUpIconMOut()
{
    document.getElementById("camUpIcon").style.filter ="invert(0%)";
}
function actCameraDownIconMOver()
{
    document.getElementById("camDownIcon").style.filter ="invert(100%)";
}
function actCameraDownIconMOut()
{
    document.getElementById("camDownIcon").style.filter ="invert(0%)";
}*/
//document.getElementById("maxTempSlideText").innerHTML = document.getElementById("maxSlider").value;
//document.getElementById("minTempSlideText").innerHTML = document.getElementById("minSlider").value;

var maxSliderIn = document.getElementById("maxSlider");
var maxSliderOut = document.getElementById("maxRangeSpan");
var minSliderIn = document.getElementById("minSlider");
var minSliderOut = document.getElementById("minRangeSpan");

maxSliderIn.oninput = function()
{
    maxSliderOut.innerHTML = this.value+"&deg;C";
}
minSliderIn.oninput = function()
{
    minSliderOut.innerHTML = this.value+"&deg;C";
}



function login()
{
	var username = document.getElementById("userName").value;
	var password = document.getElementById("password").value;
    if(password == null || password == "" || username == null || username == "")
    {
        if((password == null || password == "") && (username == null || username == "") )
		{
			alert("Username and password were not entered");
			document.getElementById("userName").style.border="solid red 1px";
			document.getElementById("password").style.border="solid red 1px";
			document.getElementById("userName").value="";
			document.getElementById("password").value="";
			return false;
		}
		else if(username == null || username == "")
		{
			alert("Username not entered");
			document.getElementById("userName").style.border="solid red 1px";
			document.getElementById("password").style.border="solid green 1px";
			document.getElementById("userName").value="";
			return false;
		}
		else if(password == null || password == "")
		{
			alert("No password entered");
			document.getElementById("userName").style.border="solid green 1px";
			document.getElementById("password").style.border="solid red 1px";
			document.getElementById("password").value="";
			return false;
		}
		else
		{
			return true;
		}
    }
}

function registerS()
{
	var errCount=0;
	var errMessage = "Error: \n";
	var errUsername = "Username Not entered \n"
	var errPassword = "Password Not entered \n"
	var errName = "Name Not entered \n"
	var errEmail = "Email Not entered \n"
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;
	var name = document.getElementById("name").value;
	var email = document.getElementById("email").value;
    if(password == null || password == "" || username == null || username == "" || name == null || name == "" || email == null || email == "")
    {
        if((password == null || password == "") && (username == null || username == "") && (name == null || name == "") && (email == null || email == "") )
		{
			alert("No fields were entered");
			document.getElementById("username").style.border="solid red 1px";
			document.getElementById("password").style.border="solid red 1px";
			document.getElementById("name").style.border="solid red 1px";
			document.getElementById("email").style.border="solid red 1px";
			return false;
		}
		if(username == null || username == "")
		{
			//alert("Username not entered");
			errMessage = errMessage.concat(errUsername);
			document.getElementById("username").style.border="solid red 1px";
			errCount++;
		}
		if(password == null || password == "")
		{
			//alert("No password entered");
			errMessage = errMessage.concat(errPassword);
			document.getElementById("password").style.border="solid red 1px";
			errCount++;
		}
		if(name == null || name == "")
		{
			errMessage = errMessage.concat(errName);
			//alert("Fullname not entered");
			document.getElementById("name").style.border="solid red 1px";
			errCount++;
		}
		if(email == null || email == "")
		{
			//alert("Email not entered");
			errMessage = errMessage.concat(errEmail);
			document.getElementById("email").style.border="solid red 1px";
			errCount++;
		}
		if(errCount!=0)
		{
			alert(errMessage);
			return false;
			
		}
		else
		{
			return true;
		}
    }
}
		
function loginBlank()
{
	document.getElementById("userName").style.border="solid grey 2px";	
}

function registerBlank()
{
	document.getElementById("username").style.border="solid grey 2px";	
}
	
function passwordBlank()
{
	document.getElementById("password").style.border="solid grey 2px";
}

function nameBlank()
{
	document.getElementById("name").style.border="solid grey 2px";
}

function eMailBlank()
{
	document.getElementById("email").style.border="solid grey 2px";
}

function errLoginCheck()
{
	var username = document.getElementById("userName").value;
	var password = document.getElementById("password").value;
	if(username == null || username == "")
	{
		document.getElementById("userName").style.border="solid red 1px";
	}
	if(password == null || password == "")
	{
		document.getElementById("password").style.border="solid red 1px";
	}
	
}

function errRegCheck()
{
	var username = document.getElementById("username").value;
	var password = document.getElementById("password").value;
	var name = document.getElementById("name").value;
	var email = document.getElementById("email").value;
	if(username == null || username == "")
	{
		//alert("Username not entered");
		document.getElementById("username").style.border="solid red 1px";
	}
	if(password == null || password == "")
	{
		document.getElementById("password").style.border="solid red 1px";
	}
	if(name == null || name == "")
	{
		document.getElementById("name").style.border="solid red 1px";
	}
	if(email == null || email == "")
	{
		document.getElementById("email").style.border="solid red 1px";
	}
	
}