<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'php-packages'.DIRECTORY_SEPARATOR.'autoload.php';
use Loadwave\App\Model;
use Loadwave\App\Library;

session_start();
if( Library::verifyToken() == false )
{
	header("Location: /?error=token");
	exit;
}

if ( isset($_COOKIE['Auth']) ) {
	$model = new Model;
	$model->deleteSession($_COOKIE['Auth']);
	setcookie("Auth", "", time()-3600, "/");
	session_start();
	session_destroy();
	$_SESSION = array();
	setcookie("PHPSESSID", "", time()-3600, "/");
	header("Location: /?success=logout");
}
else
	header("Location: /?error=generic");
