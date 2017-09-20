<?php
include_once "db.php";

function EventLoad($pEventID, &$pEvent)
{
    $loaded = false;

    $dbConn = db_r_connect ();
    $sql = "SELECT name,start,end FROM event WHERE id=\"".$pEventID."\"";
    $result = $dbConn->query($sql);
    if ($result->num_rows > 0)
    {
      $row = $result->fetch_assoc();
      $pEvent['id']            = $pEventID;
      $pEvent['name']          = $row['name'];
      $pEvent['start']         = $row['start'];
      $pEvent['end']           = $row['end'];
      $loaded=true;
    }/*if found*/
    db_r_close ($dbConn);
    return $loaded;
}/*EventLoad()()*/

function EventCall($pFunc)
{
    $dbConn = db_r_connect ();
    $sql = "SELECT evt.id,org.name as org,evt.name,evt.start,evt.end,evt.venue,evt.contact,evt.entries_until FROM event as evt left join org as org on evt.org=org.id ORDER BY start";
    $result = $dbConn->query($sql);
    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
          $pFunc($row);
        }/*while stepping through entries*/
    }/*if found*/
    db_r_close ($dbConn);
}/*EventCall()*/

?>