<?php
/* Main page with two forms: sign up and log in */
require 'db.php' ;
include('session.php');
?>
<!DOCTYPE html>
<html>
<body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script>
var userid = getParameterByName('val1');

if (confirm('你確認要將「'+userid+'」退出研究嗎？')) {
    $.ajax({
    type: "POST",
    url: 'dropout_delete.php',
    dataType: 'json',
    data: {id: userid},
    async: false,
    success:function (response) {
            window.location.replace('index.php');
            }
    });
} else {
    window.location.replace('index.php');
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
</script>
</body>
</html>
