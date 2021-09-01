<?php
    include_once 'formController.php';


    // This script handles the form - checks that it has valid address, city choise and area, then it sends form to controller to save it in DB
    $errors = [];
    $data = [];

    $address = $_POST['address'];
    $city = $_POST['city'];
    $area = $_POST['area'];
    $street = $_POST['street'];
    $house = $_POST['house'];
    $info = $_POST['info'];


    if (empty($address)) {
        $errors['address'] = 'Address name is required.';
    }

    if (empty($city)) {
        $errors['city'] = 'City is required.';
    }

    if (empty($area)) {
        $errors['area'] = 'Area is required.';
    }

    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;
    } else {
        $data['success'] = true;
        $data['message'] = 'Success!';
        saveForm($address, $city, $area, $street, $house, $info);
    }

    echo json_encode($data);
