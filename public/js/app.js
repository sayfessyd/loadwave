$(document).ready(function() {
    main = $("#main").width();
    $("#player").css("max-width", (main - 18));
    $("#comment-block").css("max-width", (main - 18));
    if (getCookie("backg") == "") {
        src = base + "css/img/back7.jpg";
        document.getElementById("backg").src = src
    } else {
        bg = getCookie("backg");
        src = base + "css/img/back" + bg + ".jpg";
        document.getElementById("backg").src = src;
        value = 'url("' + src + '")';
        document.body.style.backgroundImage = value;
        setCookie("backg", getCookie("backg"), 3)
    }
    if (getCookie("opacity") == "") {
        $("#opacity").text("0.9")
    } else {
        setCookie("opacity", getCookie("opacity"), 3)
    }
});
$(window).resize(function() {
    main = $("#main").width();
    $("#player").css("max-width", (main - 18));
    $("#comment-block").css("max-width", (main - 18))
});
$(document).ajaxStop(function() {
    $(".like").on("click", function() {
        like = $(this);
        parent = like.closest(".card");
        grandParent = like.closest(".columns");
        if (parent.css("box-shadow") == "none") {
            audio = document.getElementById("audiotag1");
            random = Math.floor((Math.random() * 9) + 1);
            audio.src = base + "audio/playful_reveal_melodic_0" + random + ".mp3";
            audio.volume = 0.2;
            audio.play();
            $("#sess-count i").text(" " + (parseInt($("#sess-count i").text(), 10) + 1));
            nb = like.children();
            save = nb.text();
            nb.text(parseInt(save, 10) + 1);
            like.removeClass("like");
            like.addClass("like-click");
            like.css({
                color: "#ee9572",
                opacity: "0.9",
            });
            like.prev(".shine").addClass("effect");
            parent.css("box-shadow", "0px 0px 20px 5px #ffefdb");
            parent.addClass("card-click");
            grandParent.css("opacity", "0.9");
            setTimeout(function() {
                like.removeClass("like-click");
                parent.removeClass("card-click");
                grandParent.addClass("animated faa-float")
            }, 2000);
            comment_id = like.next("#comment_id").text();
            $.get("/watch", {
                like: parseInt(comment_id, 10),
                token: token
            })
        }
    });
    if (!getCookie("opacity") == "") {
        var a = getCookie("opacity");
        value = "rgba(255, 255, 255, " + (parseInt(a, 10) / 10) + ")";
        $(".trans").css("background-color", value);
        $("#opacity").text((parseInt(a, 10) / 10))
    }
});

var offset = 15;
var limit = 20;
function myTimer() {
    time = parseInt(player.getCurrentTime(), 10);
    minutes = Math.floor(time / 60);
    hours = Math.floor(minutes / 60);
    seconds = time - (minutes * 60);
    timeFormat = hours + ":" + minutes + ":" + seconds;
    if ($("#limit").val() != "") {
        limit = $("#limit").val()
    }
    $.ajax({
        url: "/watch?time=" + timeFormat + "&offset=" + offset + "&limit=" + limit + "&token=" + token,
        type: "GET",
        datatype: "json",
        success: function(b, a) {
            var c = angular.element($("#main")).scope();
            c.$apply(function() {
                c.save = jQuery.parseJSON(b);
                c.comments = chunk(jQuery.parseJSON(b), 3)
            });
            $("#main").show();
            $(document).foundation("equalizer", "reflow");
            if (offset < 10) {
                value = "0" + offset
            } else {
                value = offset
            }
            $("#countdown").text(value);
        }
    })
}

function onPlayerReady(a) {
    $.urlParam = function(b) {
        var c = new RegExp("[?&]" + b + "=([^&#]*)").exec(window.location.href);
        if (c == null) {
            return null
        } else {
            return c[1] || 0
        }
    };
    myTimer()
}

var myVar;
var countdown;
function onPlayerStateChange(a) {
    if (a.data == YT.PlayerState.PLAYING) {
        $("#v-loading").show();
        if ($("#offset").val() != "") {
            offset = $("#offset").val()
        }
        if (offset < 10) {
            value = "0" + offset
        } else {
            value = offset
        }
        $("#countdown").text(value);
        myVar = setInterval(function() {
            myTimer()
        }, offset * 1000);
        countdown = setInterval(function() {
            value = parseInt($("#countdown").text(), 10) - 1;
            if (value < 10) {
                value = "0" + value
            }
            $("#countdown").text(value)
        }, 1000)
    } else {
        clearInterval(myVar);
        clearInterval(countdown)
        $("#v-loading").hide();
    }
}

function sendComment() {
    time = parseInt(player.getCurrentTime(), 10);
    minutes = Math.floor(time / 60);
    hours = Math.floor(minutes / 60);
    seconds = time - (minutes * 60);
    timeFormat = hours + ":" + minutes + ":" + seconds;
    content = document.getElementById("content").value;
    if (content.length > 140 || content.length <= 0) {
        $("#error").foundation("reveal", "open");
        return
    }
    $.ajax({
        url: "/watch",
        type: "POST",
        data: "time=" + timeFormat + "&seconds=" + time + "&content=" + content + "&token=" + token,
        datatype: "json",
        success: function(a) {
            var b = angular.element($("#main")).scope();
            b.$apply(function() {
                var c = b.comments.length;
                if (c > 0) {
                    if (b.comments[c - 1].length < 3) {
                        b.comments[c - 1].push(jQuery.parseJSON(a))
                    } else {
                        var d = [];
                        b.comments.push(d);
                        b.comments[c].push(jQuery.parseJSON(a))
                    }
                } else {
                    var d = [];
                    b.comments.push(d);
                    b.comments[0].push(jQuery.parseJSON(a))
                }
            });
            $(document).foundation("equalizer", "reflow");
            audio = document.getElementById("audiotag2");
            random = Math.floor((Math.random() * 4) + 1);
            audio.src = base + "audio/create_0" + random + ".mp3";
            audio.volume = 0.2;
            audio.play()
        }
    })
}

function biggerSize(a) {
    if (Number(a)) {
        $("#player").css("width", 320 * a);
        $("#comment-block").css("width", 320 * a);
        $("#player").css("height", 190 * a);
        $("#main").css("margin-bottom", 242 * a)
    }
    if (a == "full") {
        main = $("#main").width();
        $("#player").css("height", "90%");
        $("#player").css("width", main);
        $("#comment-block").css("width", main)
    }
}

var bg = 7;
if (getCookie("backg") != "") {
    bg = getCookie("backg")
}
var bg_max = 9;
function changeBg(a) {
    if (a == -1) {
        if (bg > 0) {
            bg--;
            src = base + "css/img/back" + bg + ".jpg";
            value = 'url("' + src + '")';
            document.body.style.backgroundImage = value;
            document.getElementById("backg").src = src;
            setCookie("backg", bg, 3)
        } else {
            bg = bg_max;
            src = base + "css/img/back" + bg + ".jpg";
            value = 'url("' + src + '")';
            document.body.style.backgroundImage = value;
            document.getElementById("backg").src = src;
            setCookie("backg", bg, 3)
        }
    }
    if (a == 1) {
        if (bg < bg_max) {
            bg++;
            src = base + "css/img/back" + bg + ".jpg";
            value = 'url("' + src + '")';
            document.body.style.backgroundImage = value;
            document.getElementById("backg").src = src;
            setCookie("backg", bg, 3)
        } else {
            bg = 0;
            src = base + "css/img/back" + bg + ".jpg";
            value = 'url("' + src + '")';
            document.body.style.backgroundImage = value;
            document.getElementById("backg").src = src;
            setCookie("backg", bg, 3)
        }
    }
}

var op = 8;
if (getCookie("opacity") != "") {
    op = parseInt(getCookie("opacity"), 10)
}
op_max = 10;
op_min = 0;
function changeOp(a) {
    if (a == -1) {
        if (op > op_min) {
            op--;
            value = "rgba(255, 255, 255, " + (op / 10) + ")";
            $(".trans").css("background-color", value);
            $("#opacity").text((op / 10));
            setCookie("opacity", op, 3)
        } else {
            op = op_max;
            value = "rgba(255, 255, 255, " + (op / 10) + ")";
            $(".trans").css("background-color", value);
            $("#opacity").text((op / 10));
            setCookie("opacity", op, 3)
        }
    }
    if (a == 1) {
        if (op < op_max) {
            op++;
            value = "rgba(255, 255, 255, " + (op / 10) + ")";
            $(".trans").css("background-color", value);
            $("#opacity").text((op / 10));
            setCookie("opacity", op, 3)
        } else {
            op = op_min;
            value = "rgba(255, 255, 255, " + (op / 10) + ")";
            $(".trans").css("background-color", value);
            $("#opacity").text((op / 10));
            setCookie("opacity", op, 3)
        }
    }
    if (op == 10) {$("#opacity").text("1.0")};
    if (op == 0) {$("#opacity").text("0.0")};
};
