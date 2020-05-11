<?php

include('../Class_Library/class_ajax_data.php');
$obj = new ajaxData();

if (isset($_POST['insert_data'])) {
    $data = $_POST['insert_data'];
    $response = $obj->insert_data($data);
    echo json_encode($response);
}

if (isset($_POST['getRecords'])) {
    $response = $obj->get_data();
    echo json_encode($response);
}
if (isset($_POST['delete_data'])) {
    $auto_id = $_POST['delete_data'];
    $response = $obj->delete_data($auto_id);
    echo json_encode($response);
}