<?php
require_once("../controller/DBController.php");
require_once("../model/Issue.php");

$id = $_POST['id'];

if ($_POST['id'] > 0) {
    $issue = new Issue();
    $res = $issue->deleteIssue($id);
    echo json_encode(array("statusCode" => 200, "data" => "Data deleted successfully !"));
} else {
    echo json_encode(array("statusCode" => 201));
}
