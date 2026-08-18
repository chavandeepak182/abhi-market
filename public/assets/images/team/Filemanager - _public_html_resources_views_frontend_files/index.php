
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>OVIPanel - Login</title>
		<link rel="icon" type="image/ico" href="etc/styles/CstyleX-master/images/favicon.ico">
		<link href="etc/styles/acp-master/css/login.css" rel="stylesheet" type="text/css">
			<!-- JQUERY NAVBAR REQUIREMENTS -->
		<script type="text/javascript" src="etc/styles/CstyleX-master/inc/jquery.min.js" language="javascript"></script>	
		<!-- END JQUERY NAVBAR REQUIREMENTS -->
		
		<!-- Anti ClickJacking protection! -->
		<style id="antiClickjack">body{display:none !important;}</style>
		<script type="text/javascript">
			document.onkeydown = function(event) {
		    if (event.keyCode == 27) {
        	event.preventDefault();
    		}
			};

			if (self === top) {
				var antiClickjack = document.getElementById("antiClickjack");
				antiClickjack.parentNode.removeChild(antiClickjack);
			} else {
				top.location = self.location;
			}
		</script>
		<!-- End of Anti ClickJacking protection! -->
		<!-- stupid IE fixes... IE sucks!! -->
		<!--[if  ie 8]>
		<style type="text/css" media="screen">
			#inUsername, #inPassword, #inForgotPassword, #inConfEmail, #inNewPass, #inNewPass2, #inOtp {
				line-height: 35px;
			}
		</style>
		<![endif]-->
		<!--[if  ie 9]>
		<style type="text/css" media="screen">
			#zlogin_header{
				filter: none;
			}
		</style>
		<![endif]-->
	<style>
	.change-skin-ul li
                {
                    display: inline-block;
                    padding-right: 5px;
                }
                 .change-skin-ul li a{
			display: inline-block;
			width: 30px;
			height: 30px;
                }
		#header_logo_for_login{
		    
			background: url("./etc/styles/acp-master/img/login/login-top.jpg") #FFC408 left center no-repeat;
			height: 177px;		    
			display: block;
			width: 100%;		
		}
		#footer_for_login {
		    background: url(./etc/styles/acp-master/img/login/login-bottom.jpg) #FFC408 right center no-repeat;
		    height: 140px;
		}
		.change-skin-ul{
		     float: right;
		     padding-top: 15px;
		}
		.change-skin-ul li a{
			cursor:auto;
		}
		.captchaPos{
			width: 58%;
			min-height: 200px;
			/*text-align: center;*/
			margin: 30px auto;
			position: absolute;
			right: 10%;
			bottom: 20%;
			left: 15%;
			top: 36%;
		}
		.captchaPos input[type="text"],.captchaPos input[type="text"]:focus,.captchaPos input[type="text"]:active{
			width: 100%;
    			padding: 7px 10px;
    			margin-left: 5px;
    			border-radius: 8px;
    			outline: none;
		}
		.captchaPos button,.captchaPos button:focus,.captchaPos button:hover,.captchaPos button:active{
			padding: 8px 13px;
    			margin-left: 8px;
    			font-size: 19px;
			border-radius: 8px;
			background-color: #F44336;
			outline: none;
		}
		.captchaPos p{
			font-size: 26px;
			margin-bottom: 14px;
		}
		#captcha{
			margin: 0px 0px 0px 32px;
		}
		.captchaInp input[type="text"]{
			margin-top: 6px;
		}
	</style>

	</head>
	<body oncontextmenu="return false">
	<div id="header_logo_for_login">
                
		<div class="header_logo_title">
			<h2>USER</h2>		</div>

	</div>	
	<div id="zlogin_main_wrapper">
		<div id="admin_notes_area">
			<div class="footer_note_main">
				<img src="etc/styles/CstyleX-master/images/ovipanellogo.jpg" style="max-width:196px;max-height:63px" />

				<div class="footer_note">
				<br/>
				<div class="note"><span class="noteheading">Note:</span> The above features are not available in other control panel.
                               		
				</div>
				</div>
				<script type="text/javascript">
				$(document).ready(function(){
				$.ajax({
		                type: 'POST',
                		url: './logincontent.php',
		                success: function(data) {
				$(".footer_note").html(data);
				},
				error: function(ts) {
				console.log(ts.responseText);

 				}
				});
				});
				</script>
				<!-- // Saravana Code Start -->
												<div>                                                     
				<a href="https://ovipanel.in/tutorials/3701-ucp-user-control-panel-faq-2" target="_blank" class="help_icon_login">
				<img src="./etc/styles/acp-master/img/login/help-icon.png" alt="help" style="max-width: 20px;vertical-align: middle;"/>
				Help
				</a>
				</div>
								<style>
				.help_icon_login
				{
					z-index:9999;
					color:#FFC408;
					float:right;
					text-decoration:none;
				}
				.help_icon_login:hover
				{
					color:#FFF;
				}
				</style>
				<!-- // Saravana Code End -->

			</div>
		</div>

		<div id="zlogin_wrapper">

		<div id="zlogin_spacer">
	
			
			<div style="height: 20px;"></div>
					</div>
		<div id="zlogin_header">
			<h2>User Login</h2>			</div>
			<div id="zlogin_box">
							<div class="login_wrapper" id="login_wrapper">
					<form method="post" action="LoginCheck.php">
						<table>
							<tr>
								<td height="35" colspan="2"><input name="inUsername" type="type" id="inUsername" maxlength="60" placeholder="Username" value=""/><span class="username_icon"></span></td>
							</tr>
							<tr>
								<td height="35" colspan="2"></td>
							</tr>
							<tr>
								<td height="35" colspan="2"><input name="inCpatcha" type="text" id="cpatchaTextBox" placeholder="Captcha" /></td>
								<td><img id="captcha" src="./captcha.php" border="0" /></td>
							</tr>
							<tr>
								<td height="35" colspan="2"></td>
							</tr>
							<tr>
								<td height="35" colspan="2" ><button type="submit" id="button" name="sublogin2" value="LogIn" class="loginToken" >Login</button></td>
							</tr>
						</table>
					</form>	
				</div>
							 
			</div>

		
		
		</div>
	<br/>
</div>
<div id="footer_for_login">
</div>
	</body>
</html>
<script language="javascript">
$(document).ready(function(){	
    document.frmZLogin.inUsername.focus();
});
</script>
<script language="JavaScript" type="text/javascript">
    <!--
    function toggleVisibility(sId, lId){
        var me=document.getElementById(sId);
        var le=document.getElementById(lId);
        if (me.style.display=="none"){
            me.style.display="block";
        }
        else {
            me.style.display="none";
        }
        if (le.style.display=="block"){
            le.style.display="none";
        }
        else {
            le.style.display="block";
        }
    }
    // -->
$('.loginToken').click(function() {
	// var d = new Date();
	// d.setTime(d.getTime() + 1*24*60*60*1000);
	// var expires = "expires="+ d.toUTCString();
        //var csfr_token = document.getElementsByName('csfr_token')[0].value;
        //document.cookie='zpcsfr='+csfr_token+';'+ expires + ';path=/';
});
$(document).ready(function(){
$.ajax({
                type: 'POST',
                url: './logincontent.php',
               	success: function(data) {
$(".footer_note").html(data);
},
error: function(ts) { 
console.log(ts.responseText);

 }
});
});
</script>
<script type="text/javascript">
        $('#frmZLogin').submit(function() {

                var d = new Date();
                d.setTime(d.getTime() + 1*24*60*60*1000);
                var expires = "expires="+ d.toUTCString();
                var username = document.getElementById('inUsername').value;
		var ServerPort = window.location.port;
		if(ServerPort == 2086 || ServerPort == 2087 ){
                	document.cookie='acp_user_cookie=acp:'+username+':;'+ expires + ';path=/';	
		}else{
                	document.cookie='ucp_user_cookie=ucp:'+username+':;'+ expires + ';path=/';
		}

                return true; // return false to cancel form action
        });
        function Redirect() {
               window.location="http://www.tutorialspoint.com";
        }
function switchpasswordicon()
{
  var input = $("#inPassword");
   $("#showtogglePassword").toggleClass("password_icon password_icon_slash");
   if (input.attr("type") === "password") {
    input.attr("type", "text");
  } else {              
    input.attr("type", "password");
  }   
}
function switchotpicon()
{
  var input = $("#inOtp");
   $("#showtoggleOtp").toggleClass("password_icon password_icon_slash");
   if (input.attr("type") === "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
}
</script>
