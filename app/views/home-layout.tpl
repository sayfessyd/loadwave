<?php use Loadwave\App\Url; ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>loadwave</title>
        <link rel="shortcut icon" href=<?= Url::asset("loadwave3.png") ?> />
        <!-- CSS -->
            <!-- libraries -->
            <link rel="stylesheet" type="text/css" href=<?= Url::asset("lib/foundation.min.css") ?> />
            <link rel="stylesheet" type="text/css" href=<?= Url::asset("lib/font-awesome.min.css") ?> />
            <link rel="stylesheet" type="text/css" href=<?= Url::asset("lib/font-awesome-animation.min.css") ?> />
            <link rel="stylesheet" type="text/css" href=<?= Url::asset("lib/ng-animation.min.css") ?> />
            <!-- application -->
            <link rel="stylesheet" type="text/css" href=<?= Url::asset("style.css") ?> />
            <link rel="stylesheet" type="text/css" href=<?= Url::asset("home.css") ?> />
        <!-- JAVASCRIPT -->
            <!-- libraries -->
            <script type="text/javascript" src=<?= Url::asset("lib/jquery.min.js") ?> ></script>
            <script type="text/javascript" src=<?= Url::asset("lib/angular.min.js") ?> ></script>
            <script type="text/javascript" src=<?= Url::asset("lib/angular-animate.min.js") ?> ></script>
            <!-- application -->
            <script type="text/javascript">
                var token = <?= '"'.$token.'"' ?>;
                var base = <?= Url::asset() ?>;
                var app = angular.module("loadwave", ['ngAnimate']);
                app.controller("HomeController", function($scope)
                {
                    $scope.videos = [];
                });
            </script>
            <script type="text/javascript" src=<?= Url::asset("script.js") ?> ></script>
            <script type="text/javascript" src=<?= Url::asset("home.js") ?> ></script>
    </head>
    <body ng-app="loadwave">
        <header>
            <div class="tab">
                <a href="#search" data-reveal-id="search"><i class="fa fa-2x fa-search faa-tada animated-hover">  </i> </a>
                <a href="#filter" data-reveal-id="filter"><i class="fa fa-2x fa-th-large faa-pulse animated-hover ">  </i> </a>
                <a href="/">
                    <img width="90px" style="position:fixed; margin-left:-50px; margin-top:-35px" src=<?= Url::asset("loadwave3.png") ?> />
                </a>
                <a href="#feedback" data-reveal-id="feedback"><i class="fa fa-2x fa-envelope faa-horizontal animated-hover"> </i> </a>
                <a href="#user" data-reveal-id="user"><i class="fa fa-2x fa-user-circle-o faa-wrench animated-hover"> </i> </a>
            </div>
        </header>
        <div id="loading" class="uil-ripple-css" style="-webkit-transform:scale(0.8)">
            <div></div>
            <div></div>
        </div>
        <div id="search" class="reveal-modal" data-reveal aria-labelledby="search" aria-hidden="true" role="dialog">
            <h3>Search </h3>
            <div class="row collapse postfix-round">
                <div class="small-9 columns">
                    <input id="search-input" type="search" placeholder="Search Videos" maxlength="40">
                </div>
                <div class="small-3 columns">
                    <a href="javascript:searchVideos()" class="alert button postfix"><i class="fa fa-search"></i></a>
                </div>
            </div>
            <a class="close-reveal-modal" aria-label="Close">&#215;</a>
        </div>
        <div id="filter" class="reveal-modal" data-reveal aria-labelledby="filter" aria-hidden="true" role="dialog">
            <h3>Filter <i class="fa fa-ellipsis-h ">  </i> </h3>
            <div class="row collapse postfix-round">
                <div class="small-12 columns">
                    <input ng-model="videoFilter" type="search" placeholder="Filter Videos">
                </div>
            </div>
            <a class="close-reveal-modal" aria-label="Close">&#215;</a>
        </div>
        <div id="feedback" class="reveal-modal medium" data-reveal aria-labelledby="feedback" aria-hidden="true" role="dialog">
            <h3>FeedBack <i class="fa fa-undo"> </i> </h3>
            <form name="feedback" method="post" action="/feedback/" >
                <div class="row">
                    <textarea name="message" rows="6" style="margin-bottom: -1px; resize: none" placeholder="Write your message hear !" maxlength="200" required></textarea>
                    <input name="token" type="hidden" value=<?= '"'.$token.'"' ?> >
                    <button type="submit">Send Message</button>
                </div>
            </form>
            <a class="close-reveal-modal" aria-label="Close">&#215;</a>
        </div>
        <div id="user" class="reveal-modal small" data-reveal aria-labelledby="user" aria-hidden="true" role="dialog">
            <ul>
                <h3>User <i class="fa fa-info-circle">  </i>nfo </h3>
                <li><strong>Username: </strong><?= htmlentities($user['username']) ?></li>
                <li><strong>Email: </strong><?= htmlentities($user['email']) ?></li>
                <li><strong>First Name: </strong><?= htmlentities($user['firstname']) ?></li>
                <li><strong>Last Name: </strong><?= htmlentities($user['lastname']) ?></li>
                <li><strong>Birthday: </strong><?= htmlentities($user['birthday']) ?></li>
                <li><strong>Country: </strong><?= htmlentities($user['country']) ?></li>
                <li><strong>Gender: </strong><?= htmlentities($user['gender']) ?></li>
                <li><i id="all-count" class="fa fa-heart-o fa-2x"><i style="font-style: normal; font-family: sans-serif"> <?= $user['likes'] ?></i></i></li>
                <li><i id="sess-count" class="fa fa-heart-o fa-2x" style="color: #ee9572"><i style="font-style: normal; font-family: sans-serif"> <?= $_SESSION['likes'] ?></i></i></li>
                <? if ($_SESSION['confirmed'] == '0'): ?>
                <li><a href=<?= '"/resend/?token='.$token.'"' ?> >Resend Confirmation Email</a></li>
                <? endif ?>
                <li><a href="#delete" data-reveal-id="delete">Delete Account</a></li>
                <br />
                <a href=<?= '"/logout/?token='.$token.'"' ?> class="button">LogOut <i class="fa fa-sign-out"> </i></a>
            </ul>
            <a class="close-reveal-modal" aria-label="Close">&#215;</a>
        </div>
        <div id="delete" class="reveal-modal small" data-reveal aria-labelledby="delete" aria-hidden="true" role="dialog">
            <i class="fa fa-question-circle fa-2x" style="color: #B20000;"><i style="font-style: normal; font-family: sans-serif"> Account Delete</i></i>
            <p>Do you really want to delete your account ?</p>
            <a href="#dismiss" class="button" onclick="$('#delete').foundation('reveal', 'close')">Dismiss</a>
            <a href=<?= '"/delete/?token='.$token.'"' ?> class="alert button">Confirm</a>
            <a class="close-reveal-modal" aria-label="Close">&#215;</a>
        </div>
        <div id="response" class="reveal-modal" data-reveal aria-labelledby="response" aria-hidden="true" role="dialog">
            <i class="fa fa-file-text-o fa-2x" style="color: #B20000;"><i style="font-style: normal; font-family: sans-serif"> Response</i></i>
            <p><br /><?= $message ?></p>
            <a class="close-reveal-modal" aria-label="Close">&#215;</a>
        </div>
        <div id="home" class="reveal-modal" data-reveal aria-labelledby="home" aria-hidden="true" role="dialog">
            <h3>Intro</h3>
            <p>loadwave changes the way you interact with videos... 😍 “loadwave” is a simple web application, it’s a kind of video sharing website based on youtube that implements a new feature, it's the possibility to make comments related to a specific moment in a video, every comment is associated to the second you have sent (Timed Comments) ⌚️. By this way, comments play the role of a descriptor 📝 for video frames.</p>
            <h3>Usage</h3>
            <p>First thing you have to do is to sign up, you can use facebook, twitter, google authentification system to save time. Then you can access to the home page where you find a dashboard and the top commented videos, you choose one of those videos. Or you can choose a video from youtube website and modify the url from:
            <a href="https://www.youtube.com/watch?v=3AtDnEC4zak">https://www.youtube.com/watch?v=3AtDnEC4zak</a>
            To
            <a href="https://loadwave.herokuapp.com/watch?v=3AtDnEC4zak">https://loadwave.herokuapp.com/watch?v=3AtDnEC4zak</a>
            </p>
            <a class="close-reveal-modal" aria-label="Close">&#215;</a>
        </div>
        <div id="main" class="large-12 medium-12 small-12 column" ng-controller="HomeController">
            <div class="small-12 medium-4 large-3 columns toggle" ng-repeat="video in videos | filter:videoFilter">
                <div class="panel radius video trans">
                    <i class="fa fa-youtube-square fa-2x"> </i> <h5>  {{ video.data.title }}</h5>
                    <img alt="Image loaded from youtube server." src="{{ video.data.thumbnails.high.url }}" />
                    <h5 class="play"><a href="/watch?v={{ video.video_id }}&start={{ video.seconds }}"><i class="fa fa-podcast fa-2x" style="margin-right: 5px;"></i> Watch Video</a></h5>
                    <h5 class="timer"><i class="fa fa-clock-o fa-2x"><i style="font-style: normal; font-family: sans-serif"> {{ video.video_time }}{{ video.data.duration }}</i></i></h5>
                    <p class="desc">{{ video.data.description }}</p>
                    <div class="panel radius trans" ng-show="video.comments">
                        <i style="float: right" class="fa like fa-heart-o fa-2x faa-pulse animated"><i style="font-style: normal; font-family: sans-serif">{{ video.comments[0][1] }}</i></i>
                        <p class="oneline">{{ video.comments[0][0] }}</p>
                    </div>
                </div>
            </div>
        </div>
        <a href="#top" id="top"><i class="fa fa-arrow-circle-up fa-2x faa-vertical animated"></i></a>
        <script type="text/javascript" src=<?= Url::asset("lib/foundation.min.js") ?> ></script>
        <script type="text/javascript" src=<?= Url::asset("lib/foundation/foundation.reveal.min.js") ?> ></script>
        <script type="text/javascript" type="text/javascript">
            $(document).foundation();
            $("#top").click(function(){
                $('html, body').animate({scrollTop : 0},700);
            });
            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            var player;
            function onYouTubeIframeAPIReady() {
              player = new YT.Player('player', {
                height: '490',
                width: '100%',
                videoId: 'U3_d2RH9bqk'
              });
            }
            <? if (isset($js_body)): echo $js_body; else: echo ""; endif;?>
            function help () {
                $("#home").foundation("reveal","open");
            }
        </script>
    </body>
</html>
