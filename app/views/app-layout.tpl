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
            <!-- application -->
            <link rel="stylesheet" type="text/css" href=<?= Url::asset("style.css") ?> />
            <link rel="stylesheet" type="text/css" href=<?= Url::asset("app.css") ?> />
        <!-- JAVASCRIPT -->
            <!-- libraries -->
            <script type="text/javascript" src=<?= Url::asset("lib/jquery.min.js") ?> ></script>
            <script type="text/javascript" src=<?= Url::asset("lib/angular.min.js") ?> ></script>
            <!-- application -->
            <script type="text/javascript">
                var token = <?= '"'.$token.'"' ?>;
                var base = <?= Url::asset() ?>;
                var app = angular.module("loadwave", []);
                app.controller("CommentController", function($scope)
                {
                    $scope.save = [];
                    $scope.comments = [];
                });
            </script>
            <script type="text/javascript" src=<?= Url::asset("script.js") ?> ></script>
            <script type="text/javascript" src=<?= Url::asset("app.js") ?> ></script>
    </head>
    <body ng-app="loadwave">
        <header>
            <div class="tab">
                <a href="#video-size" style="width: 33%" data-reveal-id="video-size"><i class="fa fa-2x fa-desktop faa-tada animated-hover">  </i> </a>
                <a href=<?= Url::getBase().'"' ?> style="width: 33%;position:fixed;margin-top:-5px">
                    <img width="90px" src=<?= Url::asset("loadwave3.png") ?> />
                    <h5 id="countdown"> 15</h5>
                </a>
                <a href="#customize" style="width: 33%" data-reveal-id="customize"><i class="fa fa-2x fa-wrench faa-wrench animated-hover"> </i> </a>
            </div>
        </header>
        <div id="video-size" class="reveal-modal" data-reveal aria-labelledby="video-size" aria-hidden="true" role="dialog">
            <div align="center">
                <h3>Video Size <a href="javascript:biggerSize('full')"><i class="fa fa-desktop">  </i></a></h3>
                <a id="x" href="javascript:biggerSize(1)"><i class="fa fa-times fa-1x"><i style="font-style: normal; font-family: sans-serif">1</i></i></a>
                <a id="xx" href="javascript:biggerSize(2)"><i class="fa fa-times fa-2x"><i style="font-style: normal; font-family: sans-serif">2</i></i></a>
                <a id="xxx" href="javascript:biggerSize(3)"><i class="fa fa-times fa-3x"><i style="font-style: normal; font-family: sans-serif">4</i></i></a>
            </div>
            <a class="close-reveal-modal" aria-label="Close">&#215;</a>
        </div>
        <div id="customize" class="reveal-modal small" data-reveal aria-labelledby="customize" aria-hidden="true" role="dialog">
            <div align="center">
                <h3>Customize <i class="fa fa-picture-o ">  </i></h3>
                <a id="arrfx" class="arr" href="javascript:changeBg(-1)"><i class="fa fa-caret-left  fa-2x"></i></a>
                <img id="backg" src="">
                <a id="arrfxx" class="arr" href="javascript:changeBg(1)"><i class="fa fa-caret-right  fa-2x"></i></a>
                <a id="arrsx" class="arr" href="javascript:changeOp(-1)"><i class="fa fa-caret-left  fa-2x"></i></a>
                <i id="opacity" class="fa fa-2x" style="font-style: normal; font-family: sans-serif">0.0</i>
                <a id="arrsxx" class="arr" href="javascript:changeOp(1)"><i class="fa fa-caret-right  fa-2x">  </i></a>
                <h3><br /> Refresh Time <i class="fa fa-refresh ">  </i></h3><small>This option take effect after replaying video.</small>
                <input type="number" id="offset" min="3" max="30" style="width: 50%" ng-model="offset" placeholder="15">
                <h3>Max Comments <i class="fa fa-comment-o">  </i></h3>
                <input type="number" id="limit" min="1" max="40" style="width: 50%" ng-model="limit" placeholder="20">
            </div>
            <a class="close-reveal-modal" aria-label="Close">&#215;</a>
        </div>
        <div id="error" class="reveal-modal" data-reveal aria-labelledby="error" aria-hidden="true" role="dialog">
            <i class="fa fa-exclamation-circle fa-2x" style="color: #B20000;"><i style="font-style: normal; font-family: sans-serif"> Error</i></i>
            <p><br />a comment must be less than 140 characters</p>
            <a class="close-reveal-modal" aria-label="Close">&#215;</a>
        </div>
        <div id="main" class="large-12 medium-12 small-12 column" ng-controller="CommentController">
            <div class="row" ng-repeat="group in comments" data-equalizer>
                <small id="index-row" style="display: none">{{ $index }}</small>
                <div ng-repeat="comment in group">
                    <small id="index-comment" style="display: none">{{ $index }}</small>
                    <div class="small-12 medium-4 large-3 columns" ng-hide="{{ comment.liked }}">
                        <div class="card panel radius trans" data-equalizer-watch>
                            <a href="javascript:void(0)" class="link">
                                <i class="shine"> </i><i style="float: right" class="fa like fa-heart-o fa-2x faa-pulse animated"><i style="font-style: normal; font-family: sans-serif">{{ comment.likes }}</i></i><small id="comment_id" style="display: none">{{ comment.id }} </small><q id="user_id">by {{ comment.username }} </q>
                            </a>
                            <p>{{ comment.content }} </p>
                        </div>
                    </div>
                    <div class="small-12 medium-4 large-3 columns animated faa-float" style="opacity: 0.9" ng-show="{{ comment.liked }}">
                        <div class="card panel radius trans" style="box-shadow: 0px 0px 20px 5px #ffefdb" data-equalizer-watch>
                            <a href="javascript:void(0)" class="link">
                                <i class="shine effect"> </i><i style="float: right; color: #ee9572; opacity: 0.9" class="fa fa-heart-o fa-2x faa-pulse animated"><i style="font-style: normal; font-family: sans-serif">{{ comment.likes }}</i></i><small id="comment_id" style="display: none">{{ comment.id }} </small><q id="user_id">by {{ comment.username }} </q>
                            </a>
                            <p>{{ comment.content }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="v-loading" class="uil-ripple-css" style="-webkit-transform:scale(0.8)">
            <div></div>
            <div></div>
        </div>
        <div>
            <div id="player"></div>
            <div id="comment-block" class="row collapse">
                <div class="small-7 columns">
                    <input type="text" id="content" ng-model="comment" placeholder="Write your comment here !">
                </div>
                <div class="small-5 columns">
                    <a href="javascript:sendComment()" class="button postfix"><!-- {{ comment.length }}  -->Publish <i class="fa fa-send" style="color: #fff"> </i></a>
                </div>
            </div>
        </div>
        <audio id="audiotag1" src="" preload="auto"> </audio>
        <audio id="audiotag2" src="" preload="auto"> </audio>
        <!-- libraries -->
        <script type="text/javascript" src=<?= Url::asset("lib/foundation.min.js") ?> ></script>
        <script type="text/javascript" src=<?= Url::asset("lib/foundation/foundation.equalizer.min.js") ?> ></script>
        <script type="text/javascript">
            $(document).foundation({
                equalizer : {
                    equalize_on_stack: true
                }
            });
            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            var player;
            function onYouTubeIframeAPIReady() {
              player = new YT.Player('player', {
                height: '200',
                width: '320',
                videoId: <?= "'".$id."'" ?>,
                playerVars: {enablejsapi: '1', playerapiid: 'player', autoplay: '0', rel: '0', fs: '0', showinfo:'0', origin: 'www.loadwave.com', start: <?= "'".$start."'" ?>},
                events: {
                  'onReady': onPlayerReady,
                  'onStateChange': onPlayerStateChange
                }
              });
            }
	    $("#content").keypress(function(e) {
		if(e.which == 13) {
			sendComment();
		}
	    });
        </script>
    </body>
</html>
