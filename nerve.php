<html>
<head><title></title></head>
<body>
test<br>
<?php
//JSON
$url = "http://api.torn.com/user/1781401?selections=bars&key=iSBoz?Tt";
$response = file_get_contents($url);
$data = json_decode($response, true);
$nerve = $data['nerve'];
echo $nerve['maximum'];
?>
</body>
</html>