/* Author:
	Commontree Inc.
*/

function submitScheduleForm(){
	document.scheduleForm.submit();
}

function formAdd(){
	document.getElementById("formAction").value = "addToSchedule";
}

function formDelete(deleteID){
	var confirmMessage = confirm("Are you sure you want to delete this entry?\n(It cannot be undone)");
	if (confirmMessage){
		document.getElementById("formAction").value = "deleteFromSchedule";
		document.getElementById("deleteScheduleID").value = deleteID;
		submitScheduleForm();
	} else {
		alert("Cancelled delete selection...");
	}
}

function formAddToScheduleTypes(){
	document.getElementById("formActionScheduleTypes").value = "addToScheduleTypes";
	document.scheduleTypesForm.submit();
}

function formUpdateScheduleTypes(updateID){
	var confirmMessage = confirm("Are you sure you want to update this entry?\n(It cannot be undone)");
	if (confirmMessage){
		document.getElementById("formActionScheduleTypes" + updateID).value = "updateScheduleTypes";
		document.getElementById("updateScheduleTypeID" + updateID).value = updateID;

		document.getElementById("scheduleTypesForm" + updateID).submit();
	} else {
		alert("Cancelled update selection...");
	}
}

function formDeleteFromScheduleTypes(deleteID){
	var confirmMessage = confirm("Are you sure you want to delete this entry?\n(It cannot be undone)");
	if (confirmMessage){
		document.getElementById("formActionScheduleTypes" + deleteID).value = "deleteFromScheduleTypes";
		document.getElementById("deleteScheduleTypeID" + deleteID).value = deleteID;

		document.getElementById("scheduleTypesForm" + deleteID).submit();
	} else {
		alert("Cancelled delete selection...");
	}
}

function formAddToIslandTypes(){
	document.getElementById("formActionIslandTypes").value = "addToIslandTypes";
	document.islandTypesForm.submit();
}

function formDeleteFromIslandTypes(deleteID){
	var confirmMessage = confirm("Are you sure you want to delete this entry?\n(It cannot be undone)");
	if (confirmMessage){
		document.getElementById("formActionIslandTypes").value = "deleteFromIslandTypes";
		document.getElementById("deleteIslandTypeID").value = deleteID;
		document.islandTypesForm.submit();
	} else {
		alert("Cancelled delete selection...");
	}
}

function formAddToSeasonTypes(){
	document.getElementById("formActionSeasonTypes").value = "addToSeasonTypes";
	document.seasonTypesForm.submit();
}

function formUpdateSeasonType(updateID){
	var confirmMessage = confirm("Are you sure you want to update this entry?\n(It cannot be undone)");
	if (confirmMessage){
		document.getElementById("formActionSeasonTypes" + updateID).value = "updateSeasonTypes";
		document.getElementById("updateSeasonTypeID" + updateID).value = updateID;

		document.getElementById("seasonTypesForm" + updateID).submit();
	} else {
		alert("Cancelled update selection...");
	}
}

function formDeleteFromSeasonTypes(deleteID){
	var confirmMessage = confirm("Are you sure you want to delete this entry?\n(It cannot be undone)");
	if (confirmMessage){
		document.getElementById("formActionSeasonTypes" + deleteID).value = "deleteFromSeasonTypes";
		document.getElementById("deleteSeasonTypeID" + deleteID).value = deleteID;
		
		document.getElementById("seasonTypesForm" + deleteID).submit();
	} else {
		alert("Cancelled delete selection...");
	}
}

function formAddToDirections(){
	document.getElementById("formActionDirection").value = "addToDirections";
	document.directionsForm.submit();
}

function formDeleteFromDirections(deleteID){
	var confirmMessage = confirm("Are you sure you want to delete this entry?\n(It cannot be undone)");
	if (confirmMessage){
		document.getElementById("formActionDirection").value = "deleteFromDirections";
		document.getElementById("deleteDirectionID").value = deleteID;
		document.directionsForm.submit();
	} else {
		alert("Cancelled delete selection...");
	}
}

function formAddToMessages(){
	document.getElementById("formActionMessage").value = "addToMessages";
	document.messagesForm.submit();
}

function formDeleteFromMessages(deleteID){
	var confirmMessage = confirm("Are you sure you want to delete this entry?\n(It cannot be undone)");
	if (confirmMessage){
		document.getElementById("formActionMessage").value = "deleteFromMessages";
		document.getElementById("deleteMessageID").value = deleteID;
		document.messagesForm.submit();
	} else {
		alert("Cancelled delete selection...");
	}
}

function setUpAddNewMemberForm()
{
	$("#memberDateAdded").datepicker(
		{
			minDate: new Date(2012, 3 - 1, 15),
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
			minDate: new Date(2012, 3 - 1, 15),
			//maxDate: new Date(2012, 12 - 1, 31),
			showButtonPanel: true,
			showOtherMonths: true,
			selectOtherMonths: true,
		}
	);
}

function logout()
{
	setACookie("memberLoginNameCookie", "", -1);
	setACookie("memberTokenCookie", "", -1);
	
	document.location = "./index.php";
}

function setActiveMenuItem(tempID)
{
	addClass(document.getElementById(tempID), "active");
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

