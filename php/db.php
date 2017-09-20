<?php


function db_r_connect ()
{
	/*jslaptop
    $dbServerName = "localhost";
    $dbUserName = "entryform_web";
    $dbPassword = 'ef$web';
    $dbName = "entryform";
*/
    $dbServerName = "sql9.cpt4.host-h.net";
    $dbUserName = "semmesmhtt";
    $dbPassword = 'g8f82B837P8';
    $dbName = "semmesmhtt_web1";
    //mysql -usemmesmhtt -pg8f82B837P8 -hsql9.cpt4.host-h.net semmesmhtt_web1

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
