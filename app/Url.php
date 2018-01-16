<?php
namespace Loadwave\App;

class Url
{

	static function getBase()
	{
		return '"//'.$_SERVER['SERVER_NAME'];
	}

	static function asset($file = null)
	{
		if ( $file != null )
		{
			$img = "/svg|png|jpg/";
			$type = substr($file, -3, 3);
			if( $type == 'css' )
				return '"//'.$_SERVER['SERVER_NAME'].'/public/css/'.$file.'"';
			elseif ( $type == '.js' )
				return '"//'.$_SERVER['SERVER_NAME'].'/public/js/'.$file.'"';
			elseif ( preg_match($img, $file) )
				return '"//'.$_SERVER['SERVER_NAME'].'/public/img/'.$file.'"';
			elseif ( $type == 'ico' ) 
				return '"//'.$_SERVER['SERVER_NAME'].'/public/'.$file.'"';
		}
		else
			return '"//'.$_SERVER['SERVER_NAME'].'/public/"';
	}

	static function getVideo()
	{
		return $_SERVER['SERVER_NAME'].'/watch?v=';
	}

}
