<?php
namespace Loadwave\App;
use Loadwave\App\Model;
use Loadwave\App\Url;
use Loadwave\Auth\BcryptHasher;
use Loadwave\App\Library;

class Controller{

	static function homePage($check)
	{
		$message = "";
		if ( isset($_GET['error']) && ($_GET['error']=="generic")  )
			$message = "Sorry, an error has occurred.";
    	elseif ( isset($_GET['error']) && ($_GET['error']=="signup") )
			$message = "Sorry, your email or your username is already used, please try to change one of them or both.";
    	elseif ( isset($_GET['success']) && ($_GET['success']=="signup") )
			$message = 'Congratulation ! , you have been registered, from now you can login to this application.';
		elseif ( isset($_GET['success']) && ($_GET['success']=="confirm") )
			$message = "Congratulation ! , your registration has been confirmed.";
		elseif ( isset($_GET['error']) && ($_GET['error']=="confirm") )
		{
			$link = ( isset($_SESSION['user_id']) )? '<a href="/resend/" >Resend Email Confirmation</a>' : '';
			$message = 'Sorry, you must confirm your registration. '.$link;
		}
    	elseif ( isset($_GET['error']) && ($_GET['error']=="login") )
			$message = 'Sorry, email and (or) password used are incorrect.';
		elseif ( isset($_GET['error']) && ($_GET['error']=="login_with") )
			$message = 'Sorry your username is already used, please try to login otherwise.';
		elseif ( isset($_GET['error']) && ($_GET['error']=="token") )
			$message = 'Sorry you have used an invalid token.';
		elseif ( isset($_GET['error']) && ($_GET['error']=="video") )
			$message = 'Sorry you have used an invalid video id.';
    	elseif ( isset($_GET['success']) && ($_GET['success']=="login") && $check === true)
			$js_body = 'function onPlayerReady(event) {event.target.playVideo();}$("#home").foundation("reveal","open");';
    	elseif ( isset($_GET['success']) && ($_GET['success']=="logout") )
			$message = 'You are disconnected.';
		elseif ( isset($_GET['success']) && ($_GET['success']=="feedback") )
			$message = 'Message sent successfully.';
		elseif ( isset($_GET['success']) && ($_GET['success']=="deleted") )
			$message = 'Account deleted successfully.';

		if ($message != "")
			$js_body = '$("#response").foundation("reveal","open");';

		$token = uniqid(rand(), true);
		$_SESSION['token'] = $token;

		if ( !$check ) {
			ob_start();
			if ( isset($_GET['register']) )
				include __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."signup.tpl";
			else
				include __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."login.tpl";
			$auth = ob_get_clean();
			ob_start();
			include __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."auth-layout.tpl";
			$html = ob_get_clean();
			echo $html;
		}
		else
		{
			$model = new Model;
			$user = $model->getUser($_SESSION['user_id']);
			ob_start();
			include __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."home-layout.tpl";
			$html = ob_get_clean();
			echo $html;
		}
	}

//Videos
	static function showVideo($id, $start = 0)
	{
		$token = uniqid(rand(), true);
		$_SESSION['token'] = $token;
		$model = new Model;
		$user = $model->getUser($_SESSION['user_id']);
		ob_start();
		include __DIR__.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."app-layout.tpl";
		$html = ob_get_clean();
		echo $html;
	}
	static function topVideos()
	{
		$model = new Model;
		$videos = $model->getVideos();
		echo json_encode($videos);
	}
	static function searchVideos($search)
	{
		$model = new Model;
		$videos = $model->getVideos($search);
		echo json_encode($videos);
	}

//Comments
	static function showComments($time, $offset, $limit)
	{
		$model = new Model;
		$values = $model->getComments($_SESSION['v'], $time, $offset, $limit, $_SESSION['user_id']);
		echo json_encode($values);
	}
	static function writeComment($video_time, $seconds, $content)
	{
		echo $_SESSION['v'];
		exit;
		$created_at = date("Y-m-d H:i:s");
		$values = array('video_id' => $_SESSION['v'], 'content' => $content, 'likes' => 0, 'created_at' => $created_at, 'video_time' => $video_time, 'seconds' => $seconds, 'username' => $_SESSION['username']);
		$model = new Model;
		$id = $model->addComment($values);
		$values = array_merge($values, array('id' => $id));
		echo json_encode($values);
	}
	static function likeComment($comment_id)
	{
		$model = new Model;
		try {
			$model->addLike($comment_id, $_SESSION['user_id']);
		} catch (Exception $e) {
			exit;
		}
		$model->incrLike($comment_id, $_SESSION['user_id']);
		$_SESSION['likes']++;
	}

//Auth
	static function check()
	{
		if ( isset($_COOKIE['Auth']) ) {
			$model = new Model;
			$session = $model->getSession($_COOKIE['Auth']);
			$now = date('Y-m-d H:i:s');
			$expire_date = date('Y-m-d H:i:s', strtotime($session['expire_date']));
			$limit_date = date('Y-m-d H:i:s', strtotime($session['limit_date']));
			if ( $session )
			{
				$_SESSION['user_id'] = $session['user_id'];
				if ( $expire_date >= $now && ($session['confirmed'] == '1' || $limit_date >= $now) )
				{
					$_SESSION['username'] = $session['username'];
					$_SESSION['confirmed'] = $session['confirmed'];
					if ( !isset($_SESSION['likes']) || $_SESSION['likes'] == '' ) {
						$_SESSION['likes'] = 0;
					}
					$expire_date = time()+3600*24*3;
					setcookie("Auth", $_COOKIE['Auth'], $expire_date, "/");
					return true;
				}
				else
					return false;
			}
			else
				return false;
		}
		else
			return false;
	}

}
