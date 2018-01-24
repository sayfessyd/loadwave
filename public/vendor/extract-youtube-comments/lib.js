function loadJSON(callback, url) {   
    var xobj = new XMLHttpRequest();
        xobj.overrideMimeType("application/json");
    xobj.open('GET', url, true);
    xobj.onreadystatechange = function () {
          if (xobj.readyState == 4 && xobj.status == "200") {
            callback(JSON.parse(xobj.responseText));
          }
    };
    xobj.send(null);  
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
    window.seconds = (f*60*60)+(d*60)+g;
}
updateVideoTime = function () {
    var sec_num = parseInt(window.startTime, 10);
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    window.video_time= hours+':'+minutes+':'+seconds;
}
function mysql_real_escape_string (str) {
    return str.replace(/[\0\x08\x09\x1a\n\r"'\\\%]/g, function (char) {
        switch (char) {
            case "\0":
                return "";
            case "\x08":
                return "";
            case "\x09":
                return "";
            case "\x1a":
                return "";
            case "\n":
                return "";
            case "\r":
                return "";
            case "\"":
            case "'":
            case "\\":
            case "%":
                return "";
        }
    });
}

 