/* Author:
	Commontree Inc.
*/

function registerNewMember()
{
	document.location = "./registerNewMember.php";
}

function setUpAddNewMemberForm()
{
	$("#memberDateAdded").datepicker(
		{
			//minDate: new Date(2012, 3 - 1, 15),
			//maxDate: new Date(2012, 12 - 1, 31),
			showButtonPanel: true,
			showOtherMonths: true,
			selectOtherMonths: true,
			//showOn: "button",
			//buttonImage: "img/calendar.gif",
			//buttonImageOnly: true,
		}
	);
	$("#memberExpiryDate").datepicker(
		{
			//minDate: new Date(2012, 3 - 1, 15),
			//maxDate: new Date(2012, 12 - 1, 31),
			showButtonPanel: true,
			showOtherMonths: true,
			selectOtherMonths: true,
		}
	);
}


/*
	Standard JS
*/

function setActiveMenuItem(tempID)
{
	addClass(document.getElementById(tempID), "active");
}

function logout()
{
	setACookie("memberLoginNameCookie", "", -1);
	setACookie("memberTokenCookie", "", -1);
	
	document.location = "./index.php";
}

function addClass(tempElement, tempValue)
{
	if (!tempElement.className) {
		tempElement.className = tempValue;
	} else {
		tempNewClassName = tempElement.className;
		tempNewClassName += " ";
		tempNewClassName += tempValue;
		tempElement.className = tempNewClassName;
	} 
}

function removeClass(tempElement, tempValue)
{
	if(tempElement.className == tempValue)
	{
		tempElement.className = "";
	}		
	else
	{
		var tempClassNameArray = tempElement.className.split(" ");
		var tempListLength = tempClassNameArray.length;
		var tempNewClassName = "";
		for(tempListCount = 0; tempListCount < tempListLength; tempListCount++)
		{
			if(tempClassNameArray[tempListCount] != tempValue)
			{
				tempNewClassName += (tempClassNameArray[tempListCount] + " ");
			}
		}
		tempElement.className = tempNewClassName;
	}
}

function setACookie(tempCookieName, tempCookieValue, tempExpireInDays)
{
	var tempExpire = new String("0");
	if(tempExpireInDays != null && tempExpireInDays != "" && Number(tempExpireInDays) > 0) {
		var tempExpiryDate = new Date();
		tempExpiryDate.setDate(tempExpiryDate.getDate() + Number(tempExpireInDays));
		tempExpire = tempExpiryDate.toGMTString();
	}
	document.cookie = tempCookieName + "=" + tempCookieValue + "; expires=" + tempExpire + "; path=/";
}

function getACookie(tempCookieName)
{
	var returnCookieValue = "";
	var tempCookie = document.cookie;
	var tempCookieArray = tempCookie.split(";");
	for(i=0; i<tempCookieArray.length; i++){
		if(tempCookieArray[i].indexOf(tempCookieName) > -1){
			var tempCookieArrayArray = tempCookieArray[i].split("=");
			returnCookieValue = tempCookieArrayArray[1];
		}
	}
	return returnCookieValue;
}

function openBrowserWindow(theURL, winName, features)
{
	window.open(theURL, winName, features);
}

function displayAlert(tempText)
{
	alert(tempText);
}

function getFocus(tempFocusID)
{
	document.getElementById(tempFocusID).focus();
}

function losefocus(tempFocusID)
{
	document.getElementById(tempFocusID).blur();
}

