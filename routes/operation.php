<?php
require_once("../controller/DBController.php");
require_once("../model/Issue.php");


if (count($_POST) > 0) {
    if ($_POST['type'] == 1) {

        $assignee = $_POST['assignee'];
        $subject = $_POST['subject'];
        $status = $_POST['status'];
        $dueDate = $_POST['dueDate'];

        $issue = new Issue();
        $isExist = $issue->getIssueBySub($subject);
        if (!$isExist) {
            $issueNo = uniqid("CRM");
            $result = $issue->addIssue($issueNo, $assignee, $subject, $status, $dueDate);
            if (empty($result)) {
                echo json_encode(array("statusCode" => 201));
            } else {
                echo json_encode(array("statusCode" => 200));
            }
        } else {
            echo json_encode(array("statusCode" => 203, "data" => "Issue already exists!"));
        }
    }
}

if (count($_POST) > 0) {
    if ($_POST['type'] == 4) {
        $ids = $_POST['id'];
        $issue = new Issue();
        $res = $issue->deleteAllIssue($ids);
        echo json_encode(array("statusCode" => 200, "data" => "Data deleted successfully !"));
    }
}
