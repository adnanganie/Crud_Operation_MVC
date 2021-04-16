<?php
require_once("../controller/DBController.php");
require_once("../model/Issue.php");

$issue = new Issue();
$img_url =   'http://localhost/task/assets/img/pic.png';

$img = $issue->file_get_contents_curl($img_url);
echo $img;
