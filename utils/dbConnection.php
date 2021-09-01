<?php

// This is the way of connecting to DB

function openCon()
{
    $dbhost = "";
    $dbuser = "";
    $dbpass = "";
    $db = "";
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);

    return $conn;
}
