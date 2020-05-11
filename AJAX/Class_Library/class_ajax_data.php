<?php

class ajaxData {

    public $db;

    function __construct() {
        if (!class_exists('connection')) {
            include 'connnection.php';
        }
        $ob = new connection();
        $this->db = $ob->getconnection();
    }

    function insert_data($data) {
        try {
            $json_data = json_decode($data, true);
            extract($json_data);
            $status = 1;
            date_default_timezone_set('Asia/Kolkata');
            $created_date = date('Y-m-d H:i:s');
            $sql = "insert into user_detail(name,email,mobile,message,status,created_date) values(:name,:email,:mobile,:message,:status,:created_date)";
            if (isset($auto_id) && $auto_id != 0) {
                $sql = "update user_detail set name= :name,email=:email,mobile=:mobile,message=:message,status=:status,updated_date = :created_date where auto_id = :auto_id";
            }
            $st = $this->db->prepare($sql);
            $st->bindParam(":name", $name, PDO::PARAM_STR);
            $st->bindParam(":email", $email, PDO::PARAM_STR);
            $st->bindParam(":mobile", $mobile, PDO::PARAM_STR);
            $st->bindParam(":message", $message, PDO::PARAM_STR);
            $st->bindParam(":status", $status, PDO::PARAM_STR);
            $st->bindParam(":created_date", $created_date, PDO::PARAM_STR);
            if (isset($auto_id) && $auto_id != 0) {
                $st->bindParam(":auto_id", $auto_id, PDO::PARAM_STR);
            }
            if ($st->execute()) {
                $response['success'] = 1;
                $response['message'] = "Inserted Successfully";
            } else {
                $response['success'] = 0;
                $response['message'] = "Insertion Failed, Try again";
            }
        } catch (Exception $ex) {
            $response['success'] = 0;
            $response['message'] = "Error " . $ex->getMessage();
        }
        return $response;
    }

    function get_data() {
        try {
            $sql = "select * from user_detail where status = 1 order by auto_id desc";
            $st = $this->db->prepare($sql);
            $st->execute();
            $row = $st->fetchAll(PDO::FETCH_ASSOC);
            if ($row) {
                $response['success'] = 1;
                $response['data'] = $row;
            } else {
                $response['success'] = 0;
                $response['message'] = "No record found";
            }
        } catch (Exception $ex) {
            $response['success'] = 0;
            $response['message'] = "Error " . $ex->getMessage();
        }
        return $response;
    }

    function delete_data($auto_id) {
        try {
            date_default_timezone_set('Asia/Kolkata');
            $created_date = date('Y-m-d H:i:s');
            $sql = "update user_detail set status = 0,updated_date=:cdate where auto_id = :auto_id";
            $st = $this->db->prepare($sql);
            $st->bindParam('auto_id', $auto_id, PDO::PARAM_STR);
            $st->bindParam('cdate', $created_date, PDO::PARAM_STR);
            if ($st->execute()) {
                $response['success'] = 1;
                $response['message'] = "Deleted Successfully";
            } else {
                $response['success'] = 0;
                $response['message'] = "Deletion Failed, Try again";
            }
        } catch (Exception $ex) {
            $response['success'] = 0;
            $response['message'] = "Error " . $ex->getMessage();
        }
        return $response;
    }

}
