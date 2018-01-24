$(document).ready(function() {
    if (getCookie("backg") != "") {
        bg = getCookie("backg");
        src = base + "css/img/back" + bg + ".jpg";
        value = 'url("' + src + '")';
        document.body.style.backgroundImage = value;
        setCookie("backg", getCookie("backg"), 3)
    }
    $("#search-input").keypress(function(a) {
        if (a.which == 13) {
            searchVideos()
        }
    })
});
$(document).ajaxStart(function() {
    $("#loading").show()
});
$(document).ajaxStop(function() {
    $("#loading").hide();
});

$.getJSON("/?top=video&token=" + token, function(b, a, c) {
    setTimeout(function() {
        var d = angular.element($("#main")).scope();
        d.$apply(function() {
            d.videos = b
        });
        getInfo(true);
        $("#main").show()
    }, 250)
});

var i = 0;
function getInfo(b) {
    var a = angular.element($("#main")).scope();
    if (a.videos.length != 0) {
        $.getJSON("https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails&id=" + a.videos[i]["video_id"] + "&key="+browser_key, function(d, c, e) {
            a.$apply(function() {
                video = a.videos[i];
                video.data = (d.items[0].snippet);
                var f = video.data.description;
                video.data.description = f.substr(0, 100) + "...";
                if (b == true) {
                    video.data.duration = convert(d.items[0].contentDetails.duration)
                } else {
                    video.data.duration = ""
                }
            });
            i++;
            if (i < a.videos.length) {
                getInfo(b)
            }
        })
    }
}

function searchVideos() {
    var a = document.getElementById("search-input").value;
    url = "/?search=" + a + "&token=" + token;
    var b = angular.element($("#main")).scope();
    b.$apply(function() {
        b.videos = []
    });
    $.getJSON(url, function(d, c, e) {
        setTimeout(function() {
            b.$apply(function() {
                b.videos = d;
                for (var g = 0; g < b.videos.length; g++) {
                    b.videos[g].comments = b.videos[g].comments.split("&ldwav,");
                    for (var f = 0; f < b.videos[g].comments.length; f++) {
                        b.videos[g].comments[f] = b.videos[g].comments[f].split("&likes:")
                    }
                }
            });
            i = 0;
            getInfo(false)
        }, 250)
    })
}
