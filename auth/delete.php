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

if ( isset($_SESSION['user_id']) ) {
    $user_id = (int)$_SESSION['user_id'];
    $model = new Model;
    $model->deleteUser($user_id);
    $model->deleteSession($user_id);
    session_destroy();
    $_SESSION = array();
    setcookie("PHPSESSID", "", time()-3600, "/");
    header("Location: /?success=deleted");
}
else
    header("Location: /?error=generic");
