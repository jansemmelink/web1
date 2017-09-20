<?php
include_once "db.php";

function MemberAccountExists ($pAccountID)
{
    $exists = false;
    $dbConn = db_r_connect ();
    $sql = "SELECT id FROM member WHERE account=\"".$pAccountID."\" limit 1;";
    $result = $dbConn->query($sql);
    if (($result != null) && ($result->num_rows > 0))
      $exists=true;

    db_r_close ($dbConn);
    return $exists;
}/*MemberAccountExists*/


function MemberLoad($pMemberOrAccountID, &$pMember)
{
    $loaded = false;

    $dbConn = db_r_connect ();
    $sql = "SELECT id,surname,name,gender,account,groupname FROM member WHERE id=\"".$pMemberOrAccountID."\" or account=\"".$pMemberOrAccountID."\"";
    $result = $dbConn->query($sql);
    if ($result->num_rows > 0)
    {
      $row = $result->fetch_assoc();
      $pMember['id']            = $row['id'];
      $pMember['surname']       = $row['surname'];
      $pMember['name']          = $row['name'];
      $pMember['gender']        = $row['gender'];
      $pMember['account']       = $row['account'];
      $pMember['groupname']     = $row['groupname'];
      $loaded=true;
    }/*if found*/
    db_r_close ($dbConn);
    return $loaded;
}/*MemberLoad()()*/

function MemberCallForAccount($pAccountID, $pFunc)
{
    $dbConn = db_r_connect ();
    $sql = "SELECT id,surname,name,gender,account,groupname FROM member WHERE account=\"".$pAccountID."\"";
    $result = $dbConn->query($sql);
    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
          $pFunc($row);
        }/*while stepping through family members*/
    }/*if found*/
    db_r_close ($dbConn);
}/*MemberCallForAccount()*/
?>