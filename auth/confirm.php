<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'php-packages'.DIRECTORY_SEPARATOR.'autoload.php';
use Loadwave\App\Model;

if ( isset($_GET['code']) && isset($_GET['id']) ) {
    if ( is_numeric($_GET['id']) ) {
            $user_id = (int)$_GET['id'];
            $model = new Model;
            $user = $model->getUser($user_id);
            if ( $user['hash'] == $_GET['code'] )
            {
                $model->confirmUser($user_id);
                if ( isset($_COOKIE['Auth']) )
                    $model->confirmSession($_COOKIE['Auth']);
                header("Location: /?success=confirm");
            }
            else
                header("Location: /?error=generic");
    }
    else
        header("Location: /?error=generic");
}
else
    header("Location: /?error=generic");
