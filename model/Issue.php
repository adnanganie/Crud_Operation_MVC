<?php
require_once("../controller/DBController.php");
class Issue
{
    private $db_handle;

    function __construct()
    {
        $this->db_handle = new DBController();
    }

    function addIssue($issueId, $assignee, $subject, $status, $dueDate)
    {

        $query = "INSERT INTO issue (issueId,assignee,subject,status,dueDate) VALUES (?, ?, ?, ?, ?)";
        $paramType = "sssss";
        $paramValue = array(
            $issueId,
            $assignee,
            $subject,
            $status,
            $dueDate
        );

        $insertId = $this->db_handle->insert($query, $paramType, $paramValue);
        return $insertId;
    }

    function updateIssue($assignee, $subject, $status, $dueDate, $issueId)
    {
        $query = "UPDATE issue SET assignee = ?,subject = ?,status = ?,dueDate = ? WHERE id = ?";
        $paramType = "ssssi";
        $paramValue = array(
            $assignee,
            $subject,
            $status,
            $dueDate,
            $issueId
        );

        $this->db_handle->update($query, $paramType, $paramValue);
    }

    function deleteIssue($issueId)
    {
        $query = "DELETE FROM issue WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $issueId
        );
        $this->db_handle->update($query, $paramType, $paramValue);
    }

    function deleteAllIssue($issueIds)
    {

        foreach ($issueIds as $id) {
            $query = "DELETE FROM issue WHERE id = ?";
            $paramType = "i";
            $paramValue = array(
                $id
            );
            $this->db_handle->update($query, $paramType, $paramValue);
        }
    }

    function getIssueById($issueId)
    {
        $query = "SELECT * FROM issue WHERE id = ?";
        $paramType = "i";
        $paramValue = array(
            $issueId
        );

        $result = $this->db_handle->runQuery($query, $paramType, $paramValue);
        return $result;
    }

    function getAllIssue()
    {
        $sql = "SELECT * FROM issue ORDER BY id desc";
        $result = $this->db_handle->runBaseQuery($sql);
        return $result;
    }


    function getIssueBySub($subject)
    {
        $query = "SELECT * FROM issue WHERE subject = ?";
        $paramType = "s";
        $paramValue = array(
            $subject
        );

        $result = $this->db_handle->runQuery($query, $paramType, $paramValue);
        return $result;
    }

    function getIssueBySub2($subject)
    {
        $query = "SELECT count(1)  FROM issue WHERE subject = ?";
        $paramType = "s";
        $paramValue = array(
            $subject
        );

        $result = $this->db_handle->runQuery2($query, $paramType, $paramValue);
        @$count = sizeof($result);
        echo $count;
        if ($count > 1) {
            return 1;
        } else {
            return 0;
        }
    }
}
