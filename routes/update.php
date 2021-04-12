<?php
require_once("../controller/DBController.php");
require_once("../model/Issue.php");
if (count($_POST) > 0) {
    $id = $_POST['id'];
    $assignee = $_POST['assignee'];
    $subject = $_POST['subject'];
    $status = $_POST['status'];
    $dueDate = $_POST['dueDate'];

    $issue = new Issue();
    $isExist = $issue->getIssueBySub($subject);

    if (!$isExist) {
        $result = $issue->updateIssue($assignee, $subject, $status, $dueDate, $id);
        echo json_encode(array("statusCode" => 200, "data" => "Data updated successfully"));
    } else {
        echo json_encode(array("statusCode" => 203, "data" => "Issue already exists!"));
    }
}
