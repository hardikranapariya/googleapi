<?php
include('./google/Google_Client.php');
include('./google/contrib/Google_Oauth2Service.php');
session_start();
//		require_once 'google/Google_Client';
$Google_Client = new Google_Client();
$Google_Client->setApplicationName("Orion");
$Google_Oauth = new Google_Oauth2Service($Google_Client);
//var_dump($Google_Oauth->userinfo->get());
//$Google_Plus = new Google_PlusService($Google_Client);

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}

if (isset($_GET['code'])) {
  $Google_Client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $Google_Client->getAccessToken();
  //header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (isset($_SESSION['access_token'])) {
  $Google_Client->setAccessToken($_SESSION['access_token']);
}

if ($Google_Client->getAccessToken()) 
{
	$userinfo = $Google_Oauth->userinfo;
	echo '<pre>';
	print_r($userinfo->get());
	echo '</pre>';

} else 
{
	$authUrl = $Google_Client->createAuthUrl();
}
?>
<html>
<head>
  <meta charset="utf-8">
  <link rel='stylesheet' href='style.css' />
</head>
<body>
<header><h1>Google+ Sample App</h1></header>
<div class="box">

<?php if(isset($personMarkup)): ?>
<div class="me"><?php print $personMarkup ?></div>
<?php endif ?>

<?php
  if(isset($authUrl)) {
	print "<a class='login' href='$authUrl'>Connect Me!</a>";
  } else {
   print "<a class='logout' href='?logout'>Logout</a>";
  }
?>
<br/>
Demo by. Hardik Ranpariya
<br/>
Email : hardik.ranapariya@artoongames.com
</div>
</body>
</html>
