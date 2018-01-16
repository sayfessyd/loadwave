<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'php-packages'.DIRECTORY_SEPARATOR.'autoload.php';
use Illuminate\Hashing\BcryptHasher;
use Loadwave\App\Model;
use Loadwave\App\Library;

session_start();
if( Library::verifyToken() == false )
{
	header("Location: /?error=token");
	exit;
}

$config = require_once "./hybridauth/config.php";
require_once "./hybridauth/Hybrid/Auth.php";

if(isset($_GET['provider']))
{
	$provider = $_GET['provider'];
	try{
		$hybridauth = new Hybrid_Auth( $config );
		$authProvider = $hybridauth->authenticate($provider);
		$user_profile = $authProvider->getUserProfile();
		if($user_profile && isset($user_profile->identifier))
		{
			$model = new Model;
			if($user_profile->email == NULL)
				$user_profile->email = $user_profile->displayName."@example.com";
			$user = $model->getUser(array('email' => $user_profile->email));
			if ( !$user ) {
				$birthday = $user_profile->birthYear."-".$user_profile->birthMonth."-".$user_profile->birthDay;
				$user = array('email' => $user_profile->email, 'username' => $user_profile->displayName, 'password' => NULL,
								'firstname' => $user_profile->firstName, 'lastname' => $user_profile->lastName,
								'gender' => $user_profile->gender, 'country' => $user_profile->country,
								'birthday' => $birthday);
				$joined_at = date("Y-m-d H:i:s");
				$user = array_merge($user, array('likes' => 0, 'joined_at' => $joined_at, 'hash' => NULL, 'confirmed' => true));
				try{
					$id = $model->setUser($user);
				}catch(PDOException $e)
				{
					header("Location: /?error=login_with");
					exit;
				}
				$user = array_merge($user, array('id' => $id));
			}
			$hasher = new BcryptHasher;
			$hash = $hasher->make($user['username']);
			$startDate = time();
			$new_date = date('Y-m-d H:i:s', strtotime('+15 day', $startDate));
			$now = date('Y-m-d H:i:s');
			$values = array('user_id' => $user['id'], 'username' => $user['username'], 'hash' => $hash, 'init_date' => $now, 'expire_date' => $new_date, 'confirmed' => true, 'limit_date' => $limit_date);
			$model->addSession($values);
			$expire_date = $startDate+3600*24*3;
			setcookie("Auth", $hash, $expire_date, "/");
			header("Location: /?success=login");
		}
	}
	catch( Exception $e )
	{

	}
}
