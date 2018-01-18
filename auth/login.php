<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
use Illuminate\Hashing\BcryptHasher;
use Loadwave\App\Model;
use Loadwave\App\Library;

session_start();
if( Library::verifyToken() == false )
{
	header("Location: /?error=token");
	exit;
}

date_default_timezone_set("Africa/Tunis");

if ( 	isset($_POST['email']) && preg_match("/^[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z_+])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9}$/", $_POST['email'])
	 && isset($_POST['password']) && (strlen($_POST['password']) >= 8) )
{
	$model = new Model;
	$user = $model->getUser($_POST);
	if ( $user ) {
		$hasher = new BcryptHasher;
		if ( $hasher->check($_POST['password'], $user['password']) ) {
			$now = date('Y-m-d H:i:s');
			$now = new DateTime($now);
			$limit_date = date_create_from_format('Y-m-d H:i:s', $user['joined_at']);
			date_add($limit_date, date_interval_create_from_date_string('3 days'));
			$limit_date = $limit_date->format('Y-m-d H:i:s');
			$now = $now->format('Y-m-d H:i:s');
			//if ( $user['confirmed'] == '1' || $limit_date >= $now ) {
				$hash = $hasher->make($_POST['username']);
				$startDate = time();
				$new_date = date('Y-m-d H:i:s', strtotime('+15 day', $startDate));
				$values = array('user_id' => $user['id'], 'username' => $user['username'], 'hash' => $hash, 'init_date' => $now, 'expire_date' => $new_date, 'confirmed' => $user['confirmed'], 'limit_date' => $limit_date);
				$model->addSession($values);
				$expire_date = $startDate+3600*24*3;
				setcookie("Auth", $hash, $expire_date, "/");
				header("Location: /?success=login");
			/*}
			else
				header("Location: /?error=confirm");*/
			/*if ( !($user['confirmed'] == '1') && !($limit_date >= $now) ) 
				header("Location: /?error=confirm");*/
		}
		else
			header("Location: /?error=login");
	}
	else
		header("Location: /?error=login");
 }
else
	header("Location: /?error=generic");
