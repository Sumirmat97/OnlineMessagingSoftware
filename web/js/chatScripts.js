function showHistory()
{
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function()
	{
		if(this.readyState == 4 && this.status == 200)
		{
			//document.getElementById("historyBox").innerHTML = this.responseText;
			var resp = emojione.unicodeToImage(this.responseText);
			document.getElementById("historyBox").innerHTML = resp;
		}
	}
	ajax.open("GET","../src/ajax/showHistory.php",true);
	ajax.send();
}

function setStarred(mid,starId) 
{
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200)
		{
			if(this.responseText === "true")
			{
				document.getElementById(starId).className = "glyphicon glyphicon-star";
			}
			else
			{
				alert("This message is already starred");
			}
		}
		
	};
	
	xhttp.open("GET", "../src/ajax/setStarred.php?mid="+mid, true);
	xhttp.send();
}

function setSeen(cid)
{
	if (window.XMLHttpRequest) 
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else 
	{
		// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
	
	xmlhttp.open("GET","../src/ajax/setSeen.php?cid="+cid,true);
	xmlhttp.send();
}

function getMessageHistory(cid){
	if (window.XMLHttpRequest) 
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else 
	{
		// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
		
	xmlhttp.onreadystatechange=function()
	{
		if(this.readyState == 4 && this.status == 200)
		{
			if(this.responseText!=null)
			{
				var result = emojione.unicodeToImage(this.responseText);
				document.getElementById("chatBox").innerHTML += result;
			}
			else
				alert("error in get message");
		}
			
			var height = 0;
			$("#chatBox div").each(function(i,value){
				height += parseInt($(this).height());
			});
			
			height += '';
			$("#chatBox").animate({scrollTop: height});

	};
	
	xmlhttp.open("GET","../src/ajax/getMessageHistory.php?cid="+cid,false);
	xmlhttp.send();
}
function liveSearch(str) 
{
   if (str.length==0)
    {
        document.getElementById("livesearch").innerHTML="";
        document.getElementById("livesearch").style.border="0px";
        return;
    }

    if (window.XMLHttpRequest)
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
	{  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function()
    {

		if(this.readyState == 4 && this.status == 200)
		{
			document.getElementById('livesearch').innerHTML = this.responseText;

		}
	};
	
    xmlhttp.open("GET","../src/ajax/livesearch.php?q="+str,true);
    xmlhttp.send();
}

function getMessages(cid,count)
{
	if (window.XMLHttpRequest) 
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else 
	{
		// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
		
	xmlhttp.onreadystatechange=function()
	{
		if(this.readyState == 4 && this.status == 200)
		{
			if(this.responseText!=null)
			{
				var result = emojione.unicodeToImage(this.responseText);
				document.getElementById("chatBox").innerHTML += result;
			}
			else
				alert("error in get message");
		}
	};
	
	xmlhttp.open("GET","../src/ajax/getMessages.php?cid="+cid+"&count="+count,true);
	xmlhttp.send();
	
}

function checkOnline(id)
{
	if (window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    }

	xmlhttp.onreadystatechange=function()
	{
		if(this.readyState == 4 && this.status == 200)
		{
			document.getElementById("user2Status").innerHTML = this.responseText;
		}
	};

	xmlhttp.open("GET","../src/ajax/checkOnline.php?id="+id,true);
	xmlhttp.send();
	
}

function acceptRequest(requestNo,senderId,receiverId)
{
	xhttp = new XMLHttpRequest();
		
	xhttp.open("GET", "../src/ajax/acceptRequest.php?requestNo="+requestNo+"&senderId="+senderId+"&receiverId="+receiverId,true);
	xhttp.send();
}

function declineRequest(requestNo)
{
	xhttp = new XMLHttpRequest();
		
	xhttp.open("GET", "../src/ajax/declineRequest.php?requestNo="+requestNo,true);
	xhttp.send();
	
}

function sendRequest(id)
{
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200)
		{	
			if(this.responseText != "sent")
			{	
				document.getElementById("requestButton").display = "none";
				document.getElementById("chatBox").innerHTML += "<div class='alert alert-warning text-center alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Friend Request Already Sent</div>";
				
			}
			else
			{
				document.getElementById("requestButton").innerHTML = "Request Sent";
				document.getElementById("requestButton").className = "btn btn-success";
			}
		}
		
	};	
	
	xhttp.open("GET", "../src/ajax/sendRequest.php?id="+id,true);
	xhttp.send();

}

//to determine if an id is a friend or not callback structure is used because returning from ajax function not possible
/* a global variable (isFriend) wil keep the result
	this will be used in show chats*/
	
	//but because of some reason this was not happening
var isFriend;

function checkFriend(id,callback)
{
	xhttp = new XMLHttpRequest();
	
	
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200)
		{	
			isFriend = this.responseText;
			//callback(this.responseText);
		}
	};	
	
	xhttp.open("GET", "../src/ajax/checkFriend.php?id="+id,false);
	xhttp.send();

}

function myCallBack(reply){
	isFriend = reply;
}

function showChat(talkingToId)
{
    if (window.XMLHttpRequest)
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
	{  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

	xmlhttp.onreadystatechange=function()
	{
		if(this.readyState == 4 && this.status == 200)
		{

			result = this.responseText;

			//removing the values of session variables from the responseText
			resultArr = result.split("|");
			cid = resultArr.pop();// remove the last element from the array 
			cid = cid.trim();

			resultNew = resultArr.join("");//join the rest of array into a string
			//display the resultNew string
			document.getElementById("messageWrapper").innerHTML = resultNew;

			
			$('[data-toggle="tooltip"]').tooltip();
			
			getMessageHistory(cid);
			
			setSeen(cid);
			checkOnline(talkingToId);
			document.getElementById("livesearch").style.display = "none";
						
			var checkIfUser2Online = setInterval(function(){ checkOnline(id) }, 10800000);
		
			checkFriend(talkingToId,myCallBack);
				
				
			if(isFriend == "no")
			{
				document.getElementById("messageBar").disabled = true;
					
				// button for sending request
				document.getElementById("chatBox").innerHTML += "<div class='col-md-12 text-center'><button id='requestButton' class='btn btn-primary'>Send Friend Request</button></div><br/><br/>";
				document.getElementById("requestButton").addEventListener("click",function(){ sendRequest(talkingToId);});
					
			}
			else
			{	
				$("#messageBar").emojioneArea();
				var SeenTimer = setInterval(function(){ setSeen(cid) }, 8000);

				var getNewMessages = setInterval(function(){ getMessages(cid,$("#chatBox .messageSent").length + $("#chatBox .messageRecieved").length)}, 8000 );
			}
		}
	};

	xmlhttp.open("GET","../src/ajax/getMessageWrapper.php?id="+talkingToId,true);
	xmlhttp.send();

}

function showRightSidebar()
{
    if (window.XMLHttpRequest)
    {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
	{  // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

	xmlhttp.onreadystatechange=function()
	{
		if(this.readyState == 4 && this.status == 200)
		{
			document.getElementById("rightSidebarWrapper").innerHTML = this.responseText;

			$(document).ready(function() {
				$("#status2").emojioneArea();
			});

			document.getElementById("chatHead").style.borderRadius = "0px";
			document.getElementById("chatFooter").style.borderRadius = "0px";
			document.getElementById("messageColumn").className = "col-md-4";
			document.getElementById("rightSidebarWrapper").style.display = "block";
		}
	};

	xmlhttp.open("GET","../src/ajax/generateRightSidebar.php",true);
	xmlhttp.send();
}

// upload files
function uploadFile()
{
	var file = _("file1").files[0];
	if(file != null)
	{
		var formdata = new FormData();
		formdata.append("file1",file);
		var ajax = new XMLHttpRequest();
		ajax.upload.addEventListener("progress",progressHandler,false);
		ajax.addEventListener("load",completeHandler,false);
		ajax.addEventListener("error",errorHandler,false);
		ajax.addEventListener("abort",abortHandler,false);

		ajax.open("POST","../src/ajax/fileUpload.php",true);
		ajax.send(formdata);

	}
}

function uploadProfilePic()
{
	var file = _("profilepic").files[0];
	if(file != null)
	{
		var formdata = new FormData();
		formdata.append("profilepic",file);
		
		var ajax = new XMLHttpRequest();
		
		ajax.upload.addEventListener("progress",progressHandler1,false);
		ajax.addEventListener("load",completeHandler1,false);
		ajax.addEventListener("error",errorHandler1,false);
		ajax.addEventListener("abort",abortHandler1,false);
		
		ajax.open("POST","../src/ajax/uploadProfilePic.php",true);
		ajax.send(formdata);

	}
}

function putOnline()
{
    xmlhttp = new XMLHttpRequest();

	xmlhttp.open("GET","../src/ajax/putOnline.php",true);
	xmlhttp.send();
	
}

function putOffline()
{
	xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange=function()
	{
		if(this.readyState == 4 && this.status == 200)
		{
			window.location = "index.php";	
		}
	};
	xmlhttp.open("GET","../src/ajax/putOffline.php",true);
	xmlhttp.send();	
}

function getStarredMessages(id)
{
	xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange=function()
	{
		if(this.readyState == 4 && this.status == 200)
		{
			var result = emojione.unicodeToImage(this.responseText);
			document.getElementById("starredBox").innerHTML += result;
		}
		

	};
	
	xmlhttp.open("GET","../src/ajax/getStarredMessages.php?ownerid="+id,true);
	xmlhttp.send();
}

function showStarredBox()
{
	xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange=function()
	{
		if(this.readyState == 4 && this.status == 200)
		{
			result = this.responseText;
			
			//removing the values of session variables from the responseText
			resultArr = result.split("|");
			id = resultArr.pop();// remove the last element from the array 
			id = id.trim();

			resultNew = resultArr.join("");//join the rest of array into a string
			
			//display the resultNew string
			document.getElementById("messageWrapper").innerHTML = resultNew;
			
			getStarredMessages(id);
		}
	};
	
	xmlhttp.open("GET","../src/ajax/getStarredMessagesWrapper.php",true);
	xmlhttp.send();
}


function getRequests(id)
{
	xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange=function()
	{
		if(this.readyState == 4 && this.status == 200)
		{
			document.getElementById("requestsBox").innerHTML = xmlhttp.responseText;
		}
	};
	
	xmlhttp.open("GET","../src/ajax/getRequests.php?receiverid="+id,true);
	xmlhttp.send();
}


function showRequestsBox()
{
	xmlhttp = new XMLHttpRequest();

	xmlhttp.onreadystatechange=function()
	{
		if(this.readyState == 4 && this.status == 200)
		{
			result = this.responseText;
			
			//removing the values of session variables from the responseText
			resultArr = result.split("|");
			id = resultArr.pop();// remove the last element from the array 
			id = id.trim();

			resultNew = resultArr.join("");//join the rest of array into a string
			
			//display the resultNew string
			document.getElementById("messageWrapper").innerHTML = resultNew;
			
			getRequests(id);
		}
	};
	
	xmlhttp.open("GET","../src/ajax/getRequestsWrapper.php",true);
	xmlhttp.send();
}


function toggleSession()
{
	xmlhttp = new XMLHttpRequest();

	xmlhttp.open("GET","../src/ajax/toggleSession.php",true);
	xmlhttp.send();
	
}

function changePassword()
{

	var password = document.getElementById("pass").value;
	var new_password = document.getElementById("new_pass").value;
	var con_password = document.getElementById("con_pass").value;

	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function()
	{
		if(this.readyState == 4 && this.status == 200)
		{
			document.getElementById("errorOnChangePassword").innerHTML = this.responseText;
		}
	};
	ajax.open("POST","../src/ajax/changePassword.php",true);
	var para = "password="+password + "&newPassword="+new_password + "&conPassword="+con_password;
	ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	ajax.send(para);//in post we put parameter in send function
}

function removeStarred(msid)
{
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200)
		{
			if(this.responseText)
			{
				document.getElementById("ms"+msid).style.display = "none";
			}
		}
	};

	xhttp.open("GET", "../src/ajax/removeStarred.php?msid="+msid, true);
	xhttp.send();
}

function deleteChatHistory()
{
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200)
		{
			if(this.responseText)
			{
				document.getElementById("chatBox").innerHTML = "";
			}
		}
	};

	xhttp.open("GET", "../src/ajax/deleteChatHistory.php", true);
	xhttp.send();
}

function enableOnLoad()
{
	putOnline();
	$("#logout").click(function(event){
		event.preventDefault();
	putOffline();
	});
	
	showHistory();
	
	var element1 = document.getElementById("searchBox");
		element1.addEventListener("focus",showSearchResults,true);
	var element2 = document.getElementsByTagName("body")[0];
		element2.addEventListener("click",hideRightSidebar,true);
	
	var historyVar = setInterval(function(){ showHistory()}, 50000);
			
}
 
 
function disableMyStatus()
{
	var element1 = document.getElementsByClassName("emojionearea-editor")[0];
		element1.setAttribute("contentEditable",false);
}

function clearSendBar()
{
	document.getElementsByClassName("emojionearea-editor")[$('.container .emojionearea-editor').length -1].innerHTML = "";
}

function showSearchResults()
{
	document.getElementById("livesearch").style.display = "block";
}

function showLeftSidebar()
{
	
	document.getElementById("userWrapper").style.display = "none";			
	document.getElementById("userWrapper").className = "";	
	
	document.getElementById("leftSidebarWrapper").className = "col-md-4";
	document.getElementById("leftSidebarWrapper").style.display = "block";
			
}

function hideLeftSidebar()
{
	document.getElementById("leftSidebarWrapper").style.display = "none";
	document.getElementById("leftSidebarWrapper").className = "";
	
	document.getElementById("userWrapper").className = "col-md-4";
	document.getElementById("userWrapper").style.display = "block";
	
}

function showStatusBox()
{
	document.getElementById("blueBox1").style.display = "none";
	document.getElementById("statusBox").style.display = "block";
		
}
function hideStatusBox(){
	
	document.getElementById("statusBox").style.display = "none";
	document.getElementById("blueBox1").style.display = "block";
}

$(document).ready(function() {
$("#statusBar").emojioneArea();
  });

$(document).ready(function() {	
$("#userStatus").emojioneArea();
  });
  

function clearSearchBar()
{
	document.getElementById("searchBar").value = "";
}

function hideRightSidebar()
{			
	document.getElementById("chatHead").style.borderRadius = "0px 10px 0px 0px";
	document.getElementById("chatFooter").style.borderRadius = "0px 0px 10px 0px";
	document.getElementById("messageColumn").className = "col-md-8";
	document.getElementById("rightSidebarWrapper").style.display = "none";
}

//functions for upload of files
function _(e1)
{
	return document.getElementById(e1);
}

function progressHandler(event)
{
	var percent = (event.loaded/event.total)*100;
	_("progressBar").value = Math.round(percent);
	_("status").innerHTML = Math.round(percent) + "%uploaded... please wait";
}

function completeHandler(event)
{
	_("status").innerHTML = event.target.responseText;
}

function errorHandler(event)
{
	_("status").innerHTML = "Upload Failed";
}
function abortHandler(event)
{
	_("status").innerHTML = "Upload Aborted";
}
function showName(name)
{
	document.getElementById("nameHolder").innerHTML = name;
}
function removeOldName()
{
	_("progressBar").value = 0;
	_("status").innerHTML = "";
}


function incognitoOpen()
{
	document.getElementById('incognito').innerHTML = "<a href='javascript:incognitoClose();'>Leave Incognito</a>";	
	
	toggleSession();
	
	document.getElementById("chatBox").innerHTML += "<div class='alert alert-info alert-dismissable fade in'><strong>Incognito Mode Started</strong> To exit:Reload or click Leave Incognito from menu.</div>";
	
}
function incognitoClose()
{
	document.getElementById('incognito').innerHTML = "<a href='javascript:incognitoOpen();'>Go Incognito</a>";
	
	toggleSession();		
	
	document.getElementById("chatBox").innerHTML += "<div class='alert alert-info alert-dismissable fade in'><strong>Incognito Mode Over</strong></div>";			
}

function progressHandler1(event)
{
	var percent = (event.loaded/event.total)*100;
	_("progressBar1").value = Math.round(percent);
	_("status1").innerHTML = Math.round(percent) + "%uploaded... please wait";
}

function completeHandler1(event)
{	
	_("status1").innerHTML = event.target.responseText;
}

function errorHandler1(event)
{
	_("status1").innerHTML = "Upload Failed";
}
function abortHandler1(event)
{
	_("status1").innerHTML = "Upload Aborted";
}
function showName1(name)
{
	document.getElementById("fileSelected").innerHTML = name;
}
function removeOldName1()
{
	_("progressBar1").value = 0;
	_("status1").innerHTML = "";
}
