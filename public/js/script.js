$(document).on("scroll", function() {
    if ($(window).scrollTop() >= 200) {
        $("#top").fadeIn()
    } else {
        $("#top").fadeOut()
    }
});

function setCookie(b, f, c) {
    var e = new Date();
    e.setTime(e.getTime() + (c * 24 * 60 * 60 * 1000));
    var a = "expires=" + e.toUTCString();
    document.cookie = b + "=" + f + "; " + a
}

function getCookie(d) {
    var b = d + "=";
    var a = document.cookie.split(";");
    for (var e = 0; e < a.length; e++) {
        var f = a[e];
        while (f.charAt(0) == " ") {
            f = f.substring(1)
        }
        if (f.indexOf(b) == 0) {
            return f.substring(b.length, f.length)
        }
    }
    return ""
}

function chunk(a, c) {
    var d = [];
    for (var b = 0; b < a.length; b += c) {
        d.push(a.slice(b, b + c))
    }
    return d
}

function convert(c) {
    var e = c.match(/\d+/g);
    if (e.length == 1) {
        e.unshift("0", "0")
    } else {
        if (e.length == 2) {
            e.unshift("0")
        }
    }
    var b = e[2];
    var g = b % 60;
    var a = Math.floor(b / 60);
    var h = e[1];
    var d = h % 60;
    var i = Math.floor(h / 60);
    var f = Number(e[0]) + i;
    if (f < 9) {
        f = "0" + f
    }
    if (d < 9) {
        d = "0" + d
    }
    if (g < 9) {
        g = "0" + g
    }
    return f + ":" + d + ":" + g
};
