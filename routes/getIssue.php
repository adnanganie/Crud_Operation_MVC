<?php
require_once ("../controller/DBController.php");
require_once ("../model/Issue.php");

$id = $_POST['id'];

if ($_POST['id'] > 0) {

    $issue = new Issue();
    $issue = $issue->getIssueById($id);
    if (empty($issue)) {
        echo json_encode(array("statusCode"=>201));
    } else {
        echo json_encode(array("statusCode"=>200, "data"=>$issue));
    }
}

?>