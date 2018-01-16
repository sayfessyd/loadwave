<?php
namespace Loadwave\App;

class Library{

    static function sumTheTime($time1, $time2) {
          $times = array($time1, $time2);
          $seconds = 0;
          foreach ($times as $time)
          {
            list($hour,$minute,$second) = explode(':', $time);
            $seconds += $hour*3600;
            $seconds += $minute*60;
            $seconds += $second;
          }
          $hours = floor($seconds/3600);
          $seconds -= $hours*3600;
          $minutes  = floor($seconds/60);
          $seconds -= $minutes*60;
          // return "{$hours}:{$minutes}:{$seconds}";
          return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    static function checkUrl($id)
    {
        $browser_key = "AIzaSyAD3eZcTp8Tp_7ou5cKrmcZpLopbgK9RwY";
        $url = "https://www.googleapis.com/youtube/v3/videos?part=id&id=".$id."&key=".$browser_key;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL,$url);
        $result = curl_exec($ch);
        curl_close($ch);
        $video = json_decode($result, true);
        if ($video['pageInfo']['totalResults']!=0)
            return true;
        else
            return false;
    }

    static function checkTime($time)
    {
        $pattern1 = '/^(0?\d|1\d|2[0-3]):(0?\d|[1-5]\d):(0?\d|[1-5]\d)$/';
        return preg_match($pattern1, $time);
    }

    static function verifyToken()
    {
        if (isset($_SESSION['token']) && isset($_REQUEST['token']) && $_SESSION['token'] == $_REQUEST['token'])
        {
            //if($_SERVER['HTTP_REFERER'] == "http://".$_SERVER['SERVER_NAME']."/")
                return true;
        }
        else
            return false;
    }

}
