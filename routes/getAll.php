<?php
require_once ("../controller/DBController.php");
require_once ("../model/Issue.php");


    $issue = new Issue();
    $issues = $issue->getAllIssue();

    if (empty($issues)) {
        echo json_encode(array("statusCode"=>201));
    } else {
        echo json_encode(array("statusCode"=>200, "data" =>$issues));
    }


?>