<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
use Loadwave\App\Controller;
use Loadwave\App\Library;

session_start();
date_default_timezone_set("Africa/Tunis");

//Top
if ( isset($_GET['top']) && $_GET['top'] == "video" )
{
	if( isset($_SESSION['username']) )
	{
		if( Library::verifyToken() == false )
		{
			header("Location: /?error=token");
			exit;
		}
		Controller::topVideos();
	}
}
//Search
elseif ( isset($_GET['search'])  )
{
	if ( (strlen($_GET['search']) <= 40 && strlen($_GET['search']) > 0) && isset($_SESSION['username']) )
	{
		if( Library::verifyToken() == false )
		{
			header("Location: /?error=token");
			exit;
		}
		Controller::searchVideos($_GET['search']);
	}
}
//Comments Show
elseif ( isset($_GET['time']) && isset($_GET['offset']) && isset($_GET['limit']) )
{
	if ( Library::checkTime($_GET['time']) && is_numeric($_GET['offset']) && is_numeric($_GET['limit']) && isset($_SESSION['v']) )
	{
		if( Library::verifyToken() == false )
		{
			header("Location: /?error=token");
			exit;
		}
		$offset = (int)$_GET['offset'];
		$limit = (int)$_GET['limit'];
		return Controller::showComments($_GET['time'], $offset, $limit);
	}
}
//Comment Post
elseif ( isset($_POST['time']) && isset($_POST['seconds']) && isset($_POST['content'])  )
{
	$content = $_POST['content'];
	if ( Library::checkTime($_POST['time']) && is_numeric($_POST['seconds']) && (strlen($content) <= 140 && strlen($content) > 0) && isset($_SESSION['v'])  )
	{
		if( Library::verifyToken() == false )
		{
			header("Location: /?error=token");
			exit;
		}
		$seconds = (int)$_POST['seconds'];
		return Controller::writeComment($_POST['time'], $seconds, $content);
	}
}
//Comment Like
elseif ( isset($_GET['like'])  )
{
	if ( is_numeric($_GET['like']) && isset($_SESSION['v']) )
	{
		if( Library::verifyToken() == false )
		{
			header("Location: /?error=token");
			exit;
		}
		$like = (int)$_GET['like'];
		Controller::likeComment($like);
	}
}
//App
elseif ( isset($_GET['v']) )
{
	if ( Controller::check() )
	{
		$_SESSION['v'] = $_GET['v'];
		if ( Library::checkUrl($_SESSION['v']) == true )
		{
			if ( isset($_GET['start']) && is_numeric($_GET['start']) )
			{
				$start = (int)$_GET['start'];
				return Controller::showVideo($_SESSION['v'], $start);
			}
			return Controller::showVideo($_SESSION['v']);
		}
		else
		{
			session_destroy();
			header("Location: /?error=video");
		}
	}
	else
		header("Location: /?error=login");
}
//Home
else
{
	$check = Controller::check();
	return Controller::homePage($check);
}
