<?php
include_once "db.php";
include_once "event.php";
include_once "log.php";
include_once "member.php";

function EntryCreate($pEventID, $pMemberID, $pNameS, $pSurnameS, $pGenderS, $pGroupNameS, $pTransportS)
{
    debug ("Creating entry...");
    //validate required values
    //event id must be specified and must exist in event table
    if (!EventLoad ($pEventID, $Event))
        return false;

    //if member id is specified, it must exist
    if (IsSet ($pMemberID)) {
        if (!MemberLoad ($pMemberID, $Member))
            return false;
    }/*if member id specified*/
    else {
        $Member['id'] = "";
        $Member['name'] = $pNameS;
        $Member['surname'] = $pSurnameS;
        $Member['gender'] = $pGenderS;
        $Member['groupname'] = $pGroupNameS;
        $Member['account'] = "";
    }/*if no member id*/

    if (!IsSet ($Member['name']))
        return false;

    //generate a new db id for the entry
    $entryID = DbNewID(15);

    $created = false;

    $dbConn = db_r_connect ();
    $sql = "INSERT into entry set id=\"".$entryID."\",event_id=\"".$pEventID."\",member_id=\"".$pMemberID."\",surname=\"".$Member['surname']."\",name=\"".$Member['name']."\",account=\"".$Member['account']."\",groupname=\"".$Member['groupname']."\",gender=\"".$Member['gender']."\",transport=\"".$pTransportS."\",cost=\"0\"";
    if ($dbConn->query($sql) === TRUE)
        $created = true;

    db_r_close ($dbConn);
    return $created;
}/*EntryCreate()*/

function EntryLoad($pEventID, $pMemberID, &$Entry)
{
    return false;
}/*EntryLoad()*/
?>