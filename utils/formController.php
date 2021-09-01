<?php

include_once 'dbConnection.php';

// Form controller - saves forms, gets back user's data and creates the form table

function saveForm($address, $city, $area, $street, $house, $info)
{
    init();

    $conn = OpenCon();
    $query = "INSERT INTO forms (address_name, city, area, street, house, info) VALUES (?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssss', $address, $city, $area, $street, $house, $info);
    if ($stmt->error) {
        echo $stmt->error;
    }
    $stmt->execute();
    if ($stmt->error) {
        echo $stmt->error;
    }
    $conn->close();
}

function getUserData()
{
    $conn = OpenCon();
    $query = "SELECT address_name,city,area,street,house,info FROM `forms` ORDER BY address_name";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close();
    return $result;
}


// This function creates table if it doesn't exist and the first moment when data is sent
function init()
{
    $conn = openCon();
    $conn->query('CREATE TABLE IF NOT EXISTS `forms` (id INT AUTO_INCREMENT primary key NOT NULL, address_name VARCHAR(30) NOT NULL, city VARCHAR(20) NOT NULL, area VARCHAR(30), street VARCHAR(30), house VARCHAR(20), info VARCHAR(100), created TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)');
    echo $conn->error;
    $conn->close();
}
