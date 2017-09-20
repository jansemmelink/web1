<?php


function db_r_connect ()
{
    $dbServerName = "localhost";
    $dbUserName = "entryform_web";
    $dbPassword = 'ef$web';
    $dbName = "entryform";

    // Create connection
    $dbConn = new mysqli($dbServerName, $dbUserName, $dbPassword, $dbName);

    // Check connection
    if ($dbConn->connect_error) {
        die("Connection failed: " . $dbConn->connect_error);
    }
    //echo "Database Connected successfully";
    return $dbConn;
}/*db_r_connect()*/

function db_r_close ($dbConn)
{
    $dbConn->close();
}/*db_r_close()*/

function DbNewID ($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}/*DbNewID()*/
?>