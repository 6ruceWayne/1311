<?php
include_once 'formController.php';

// This script sanitize data from XSS attacks and forms it into JSON

convertToJson(getUserData());


function convertToJson($result)
{
    $myArray = array();
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $myArray[] = sanitize($row);
    }
    echo json_encode($myArray);
}

function sanitize($row)
{
    $sanit_row = array();
    foreach ($row as $key => $value) {
        $sanit_row[$key] = htmlspecialchars($value);
    }
    return $sanit_row;
}
