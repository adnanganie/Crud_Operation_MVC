<?php
require_once("../controller/DBController.php");
require_once("../model/Issue.php");


$img_url =   'http://localhost/task/assets/img/pic.png';

$res =   base64_encode(file_get_contents($img_url));
echo '<img width="350" height="250" class="img" src="data:image/jpeg;base64,' . $res . '">';
