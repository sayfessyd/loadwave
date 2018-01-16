<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'php-packages'.DIRECTORY_SEPARATOR.'autoload.php';
use Loadwave\App\Model;
use Loadwave\App\Library;

session_start();
if(Library::verifyToken()==false)
	exit;

date_default_timezone_set("Africa/Tunis");

if ( isset($_SESSION['username']) && isset($_POST['message']) && strlen($_POST['message']) <= 200 && strlen($_POST['message']) > 0 )  {
	$created_at = date("Y-m-d H:i:s");
	$values = array('username' => $_SESSION['username'], 'message' => $_POST['message'], 'created_at' => $created_at);
	$model = new Model;
	$model->sendMessage($values);
	header("Location: /?success=feedback");
}
else
	header("Location: /?error=generic");
