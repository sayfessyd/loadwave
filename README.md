<a href="http://www.youtube.com/watch?feature=player_embedded&v=BWq4d65fdmw
" target="_blank"><img src="http://img.youtube.com/vi/BWq4d65fdmw/maxresdefault.jpg" 
alt="IMAGE ALT TEXT HERE" width="640" height="360" border="0" /></a>


## Intro
**loadwave** changes the way you interact with videos... :heart_eyes: “loadwave” is a simple web application, it’s a kind of video sharing website based on youtube that implements a new feature, it is the possibility to make comments related to a specific moment in a video, every comment is associated to the second you have sent (**Timed Comments**) :watch:. By this way, comments play the role of a descriptor :memo: for video frames.

## Features
+ **Responsive Design** Fully responsive :iphone: and will scale to the size of any device using Foundation 5.
+ **Auth System** Complete Membership System  :family: With Social Login and Register using HybridAuth 2.9.
+ **Search** Powerful search :mag_right: that will find nearly any comment.
+ **Appearence** Easily change the look  :necktie: of loadwave.
+ **Flexibility** Easily change Refresh Time :eyeglasses:, Max Comments :speech_balloon:, Video Size :computer: ... 
+ **Rating System** Rate a comment, like it ! :sparkling_heart:.

## Usage
First thing you have to do is to sign up, you can use facebook, twitter, google authentification system to save time. Than you can access to the home page where you find a dashboard and the top commented videos, you choose one of those videos. Or you can choose a video from youtube website and modify the url from: http://www.youtube.com/watch?v=U3_d2RH9bqk To http://loadwave.localhost/watch?v=U3_d2RH9bqk

## Requirements
+ PHP 5.3.7 or Higher
+ MCrypt PHP Extension
+ PDO Extension (enabled by default)
+ CURL Library Installed
+ mod_rewrite = enabled
+ Disable ONLY_FULL_GROUP_BY mysql mode

## API's
+ **YouTube API Key**
Change browser_key variable in Library.php and home.js files.

+ **Facebook Twitter Google API Key**
Add your keys in HybridAuth config file. For more information https://hybridauth.github.io/documentation.html

