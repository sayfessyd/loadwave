# loadwave

<p align="center">
    <a href="https://loadwave.herokuapp.com/">
        <img width="100" src="https://raw.githubusercontent.com/sayfessyd/loadwave/master/public/img/loadwave3.png"><br>
    </a>
    A video sharing webapp with the possibility to make <b>Timed Comments</b>.<br>
    <a href="https://loadwave.herokuapp.com/">Live app on Heroku</a>
</p>

<p align="center">
    <a href="https://packagist.org/packages/sayfessyd/loadwave"><img src="https://img.shields.io/packagist/dt/sayfessyd/loadwave.svg" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/sayfessyd/loadwave"><img src="https://img.shields.io/packagist/php-v/sayfessyd/loadwave.svg"></a>
    <a href="https://github.com/sayfessyd/loadwave/blob/master/LICENSE"><img src="https://img.shields.io/github/license/sayfessyd/loadwave.svg" alt="License"></a>
</p>

<div align="center">
    <a href="https://loadwave.herokuapp.com/">
        <img src="https://raw.githubusercontent.com/sayfessyd/loadwave/master/public/screenshots/auth.jpg" width="150">
    </a>
    <a href="https://loadwave.herokuapp.com/">
        <img src="https://raw.githubusercontent.com/sayfessyd/loadwave/master/public/screenshots/home.jpg" width="150">
    </a>
    <a href="https://loadwave.herokuapp.com/">
        <img src="https://raw.githubusercontent.com/sayfessyd/loadwave/master/public/screenshots/app.jpg" width="150">
    </a>
</div>

------

## Intro
**loadwave** changes the way you interact with videos... “loadwave” is a video sharing webapp based on youtube with the possibility to make comments related to a specific moment in a video. Every comment is associated to the second you have sent (**Timed Comments**). By this way, comments play the role of a descriptor for video frames.


## Usage
First thing you have to do is to sign up, you can use facebook, twitter, google authentification system to save time. Then you can access to the home page where you find a dashboard and the top commented videos, you choose one of those videos. Or you can choose a video from youtube website and modify the url from: http://www.youtube.com/watch?v=U3_d2RH9bqk To https://loadwave.herokuapp.com/watch?v=U3_d2RH9bqk

## Collaborating
At this moment, the loadwave app runs under a basic heroku web server with the simplest features and needs much more investment to improve it. For those who want to collaborate, please send your requests by email to specialappdev@gmail.com.

## Install

### Composer
<pre>
composer require sayfessyd/loadwave
</pre>

## Demo
#### URL
<a href="https://loadwave.herokuapp.com/">https://loadwave.herokuapp.com/</a>
#### Note
All comments you will find out initially are extracted from youtube server and injected arbitrarily in the app database.


## Features
+ **Responsive Design** Fully responsive :iphone: and will scale to the size of any device using Foundation 5.
+ **Auth System** Complete Membership System  :family: With Social Login and Register using HybridAuth 2.9.
+ **Search** Powerful search :mag_right: that will find nearly any comment.
+ **Appearence** Easily change the look  :necktie: of loadwave.
+ **Flexibility** Easily change Refresh Time :eyeglasses:, Max Comments :speech_balloon:, Video Size :computer: ...
+ **Rating System** Rate a comment, like it ! :sparkling_heart:.

## Requirements
+ PHP 5.6.4 or Higher
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

