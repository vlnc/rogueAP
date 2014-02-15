<? session_start ();
$urlUser = $_SESSION['url'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=400, user-scalable=no" />
<link rel="apple-touch-icon" href="im/LogoFreeWifi.png" />
<title>FreeWifi</title>
<link rel="stylesheet" type="text/css" href="css/small.css" media="screen" />
<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
-->
</script>
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
      <h1 class="red">CONNEXION AU SERVICE REUSSIE</h1>
      <br />
    </div>
  </div>
</div>
</body>
</html>
<?
	header ('Refresh: 2;URL='.$urlUser);
?>

