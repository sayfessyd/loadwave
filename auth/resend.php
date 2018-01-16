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
    $user = $model->getUser($user_id);
    $to = $user['email'];
    $subject = "Email Confirmation";
    $confirm = "?code=".$user['hash']."&id=$user_id";
    $message = '<div><h1>Please, confirm your registration !</h1>';
    $message .= "<br /><h3>these are your personal information:</h3>";
    $message .= '<br /><ul style="text-align: justify"><li><strong>Email: </strong>'.$user["email"].'</li>
                            <li><strong>First Name: </strong>'.$user["firstname"].'</li><li><strong>Last Name: </strong>'.$user["lastname"].'</li>
                            <li><strong>Gender: </strong>'.$user["gender"].'</li><li><strong>Country: </strong>'.$user["country"].'</li>
                            <li><strong>Birthday: </strong>'.$user["birthday"].'</li></ul>';
    $message .= '<br /><a href="/confirm/'.$confirm.'">Click hear to confirm</a></div>';
    $header = "From:contact@loadwave.com\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";
    //echo $message;
    mail ($to,$subject,$message,$header);
}
else
    header("Location: /?error=generic");
