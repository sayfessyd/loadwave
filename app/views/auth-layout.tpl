<? use Loadwave\App\Url; ?>
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
            <link rel="stylesheet" type="text/css" href=<?= Url::asset("lib/font-awesome.min.css") ?>  />
            <link rel="stylesheet" type="text/css" href=<?= Url::asset("lib/font-awesome-animation.min.css") ?> />
            <!-- application -->
            <link rel="stylesheet" type="text/css" href=<?= Url::asset("style.css") ?> />
            <link rel="stylesheet" type="text/css" href=<?= Url::asset("auth.css") ?> />
        <!-- JAVASCRIPT -->
            <!-- libraries -->
            <script type="text/javascript" src=<?= Url::asset("lib/jquery.min.js") ?> ></script>
            <!-- application -->
            <script type="text/javascript" src=<?= Url::asset("script.js") ?> ></script>
    </head>
    <body>
        <header>
            <div align="center">
                <img width="90px" style="margin-top: -5px" src=<?= Url::asset("loadwave3.png") ?> />
            </div>
        </header>
        <div id="response" class="reveal-modal" data-reveal aria-labelledby="response" aria-hidden="true" role="dialog">
            <i class="fa fa-file-text-o fa-2x" style="color: #B20000"><i style="font-style: normal; font-family: sans-serif"> Response</i></i>
            <p><br /><?= $message ?></p>
            <a class="close-reveal-modal" aria-label="Close">&#215;</a>
        </div>
        <div class="authHomePage">
            <?= $auth ?>
        </div>
        <a href="#top" id="top"><i class="fa fa-arrow-circle-up fa-2x faa-vertical animated"></i></a>
        <!-- libraries -->
        <script type="text/javascript" src=<?= Url::asset("lib/foundation.min.js") ?> ></script>
        <script type="text/javascript" src=<?= Url::asset("lib/foundation/foundation.abide.min.js") ?>></script>
        <script type="text/javascript" src=<?= Url::asset("lib/foundation/foundation.reveal.min.js") ?> ></script>
        <script type="text/javascript">
            $(document).foundation(
                { abide :
                    { patterns :
                        { alpha: /^[a-zA-Z]+$/,
                          pass_field: /.{8,}/,
                          user_field: /.{4,}/,
                          date: /(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))/
                        }
                    }
                }
            );
            $("#top").click(function(){
                $('html, body').animate({scrollTop : 0},700);
            });
            <? if (isset($js_body)): echo $js_body; endif ?>
        </script>
    </body>
</html>
