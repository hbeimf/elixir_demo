<?php

// $url = "http://quotes.money.163.com/service/chddata.html?code=1002566&start=20150104&end=20160108";
$url = "http://quotes.money.163.com/service/chddata.html?code=1002566&start=20000104&end=20160108";
$con = file_get_contents($url);
$con = iconv("GBK", "UTF-8", $con);
echo file_put_contents("./data.cvs", $con);

?>