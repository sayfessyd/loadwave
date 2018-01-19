# loadwave

<p align="center">
    <a href="https://tailwindcss.com/" target="_blank"><img width="100" src="https://raw.githubusercontent.com/sayfessyd/loadwave/master/public/img/loadwave3.png"></a><br>
    A video sharing webapp with the possibility to make Timed Comments.
</p>

<p align="center">
    <a href="https://travis-ci.org/sayfessyd/loadwave"><img src="https://img.shields.io/travis/sayfessyd/loadwave.svg?style=for-the-badge" alt="Build Status"></a>
    <a href="https://packagist.org/packages/sayfessyd/loadwave"><img src="https://img.shields.io/packagist/dt/sayfessyd/loadwave.svg?style=for-the-badge" alt="Total Downloads"></a>
    <a href="https://github.com/sayfessyd/loadwave/blob/master/LICENSE"><img src="https://img.shields.io/github/license/sayfessyd/loadwave.svg?style=for-the-badge" alt="License"></a>
</p>

------
<div align="center">
    <img src="https://raw.githubusercontent.com/sayfessyd/loadwave/master/public/screenshots/auth.jpg" width="150">
    <img src="https://raw.githubusercontent.com/sayfessyd/loadwave/master/public/screenshots/home.jpg" width="150">
    <img src="https://raw.githubusercontent.com/sayfessyd/loadwave/master/public/screenshots/app.jpg" width="150">
</div>

## Intro
**loadwave** changes the way you interact with videos...“loadwave” is a video sharing webapp based on youtube with the possibility to make comments related to a specific moment in a video. Every comment is associated to the second you have sent (**Timed Comments**) . By this way, comments play the role of a descriptor for video frames.


## Usage
First thing you have to do is to sign up, you can use facebook, twitter, google authentification system to save time. Than you can access to the home page where you find a dashboard and the top commented videos, you choose one of those videos. Or you can choose a video from youtube website and modify the url from: http://www.youtube.com/watch?v=U3_d2RH9bqk To http://loadwave.localhost/watch?v=U3_d2RH9bqk

## Install

### Composer
<pre>
composer require sayfessyd/loadwave
</pre>

## Features
+ **Responsive Design** Fully responsive :iphone: and will scale to the size of any device using Foundation 5.
+ **Auth System** Complete Membership System  :family: With Social Login and Register using HybridAuth 2.9.
+ **Search** Powerful search :mag_right: that will find nearly any comment.
+ **Appearence** Easily change the look  :necktie: of loadwave.
+ **Flexibility** Easily change Refresh Time :eyeglasses:, Max Comments :speech_balloon:, Video Size :computer: ... 
+ **Rating System** Rate a comment, like it ! :sparkling_heart:.

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

