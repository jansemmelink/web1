<?php
include_once "db.php";
include_once "member.php";

//user module always works with session
session_start();

function UserInit(&$User)
{
    $User['id']        = "";
    $User['name']      = "";
    $User['surname']   = "";
    $User['email']     = "";
    $User['telephone'] = "";
    $User['account']   = "";
    $User['pwsha1']    = "";
    $User['password']  = "";
    return;
}/*UserInit()*/

function UserCopy(&$UserSrc, &$UserTgt)
{
    $UserTgt['id']        = $UserSrc['id'];
    $UserTgt['name']      = $UserSrc['name'];
    $UserTgt['surname']   = $UserSrc['surname'];
    $UserTgt['email']     = $UserSrc['email'];
    $UserTgt['telephone'] = $UserSrc['telephone'];
    $UserTgt['family']    = $UserSrc['account'];
    $UserTgt['pwsha1']    = $UserSrc['pwsha1'];
    $UserTgt['password']  = "";
    return;
}/*UserInit()*/

function UserCreate($User, &$UserCreated, &$ErrorMessage)
{
    //validate the specified user details
    $ErrorMessage="";
    //note: user id should not be specified
    if (!UserValidName($User['name']))           { $ErrorMessage="Invalid name.";      return false; }
    if (!UserValidName($User['surname']))        { $ErrorMessage="Invalid surname.";   return false; }
    if (!UserValidEmail($User['email']))         { $ErrorMessage="Invalid email.";     return false; }
    if (!UserValidTelephone($User['telephone'])) { $ErrorMessage="Invalid telephone."; return false; }
    if (!UserValidAccount($User['account']))     { $ErrorMessage="Invalid account.";   return false; }
    //note: user pwsha1 should not be specified

    //make sure the email is not already registered
    if (UserLoadByEmail ($User['email'], $ExistingUser)) { $ErrorMessage="Existing email.";   return false; }

    //make a new random id
    $User['id'] = DbNewId(15);

    //make a random password
    $newUserPassword = DbNewId(6);
    $User['pwsha1']  = sha1($newUserPassword);

    //create the new user
    $created = false;
    $dbConn = db_r_connect ();
    $sql = "INSERT into user set"
        ." id=\"".$User['id']."\""
        .",email=\"".$User['email']."\""
        .",name=\"".$User['name']."\""
        .",surname=\"".$User['surname']."\""
        .",telephone=\"".$User['telephone']."\""
        .",account=\"".$User['account']."\""
        .",pwsha1=\"".$User['pwsha1']."\";";
    if ($dbConn->query($sql) === TRUE)
    {
        UserCopy($UserCreated, $User);
        db_r_close ($dbConn);

        // send account details in email
        $msg = "Welcome to members.\n"
            ." Please login here with password ".$newUserPassword."\n";
        // use wordwrap() if lines are longer than 70 characters
        //$msg = wordwrap($msg,70);
        // send email
        mail ($UserCreated['email'], "Member Registration", $msg);
        return true;
    }//if created

    db_r_close ($dbConn);
    $ErrorMessage="Failed to create new user.";
    return false;
}/*UserCreate()*/


function UserUpdate($User, &$UserUpdated, &$ErrorMessage)
{
    //validate the specified user details
    $ErrorMessage="";

    //note: user id should be specified for update, and must exist
    if (!isset ($User['id']))                       { $ErrorMessage="Missing User Id."; return false; }
    if (!UserLoadById ($User['id'], $ExistingUser)) { $ErrorMessage="Unknown User Id=".$User['id']; return false; }

    //update only changed fields
    $changes = 0;
    if (($User['name']      != $ExistingUser['name']))      $changes += 1;
    if (($User['surname']   != $ExistingUser['surname']))   $changes += 1;
    if (($User['email']     != $ExistingUser['email']))     $changes += 1;
    if (($User['telephone'] != $ExistingUser['telephone'])) $changes += 1;
    if (($User['account']   != $ExistingUser['account']))   $changes += 1;

    if ($changes == 0)
        return true;

    //somethine changes: validate and update
    if (!UserValidName($User['name']))           { $ErrorMessage="Invalid name.";      return false; }
    if (!UserValidName($User['surname']))        { $ErrorMessage="Invalid surname.";   return false; }
    if (!UserValidEmail($User['email']))         { $ErrorMessage="Invalid email.";     return false; }
    if (!UserValidTelephone($User['telephone'])) { $ErrorMessage="Invalid telephone."; return false; }
    if (!UserValidAccount($User['account']))     { $ErrorMessage="Invalid account.";   return false; }
    //note: user pwsha1 should not be specified

    //update the user profile
    $created = false;
    $dbConn = db_r_connect ();
    $sql = "UPDATE user set"
        ." email=\"".$User['email']."\""
        .",name=\"".$User['name']."\""
        .",surname=\"".$User['surname']."\""
        .",telephone=\"".$User['telephone']."\""
        .",account=\"".$User['account']."\""
        ." where id=\"".$User['id']."\";";
    if ($dbConn->query($sql) === TRUE)
    {
        //user updated
        UserCopy($UserUpdated, $User);
        db_r_close ($dbConn);

        //if this is the logged in use, update session data
        if ($_SESSION['user']['id'] == $User['id'])
            $_SESSION['user'] = $User;

        return true;
    }//if created

    db_r_close ($dbConn);
    $ErrorMessage="Failed to update user.";
    return false;
}/*UserUpdate()*/


function UserLoadByEmail($Email, &$User)
{
    $loaded = false;
    $dbConn = db_r_connect ();
    $sql = "SELECT id,name,surname,email,telephone,account,pwsha1 FROM user WHERE email=\"".$Email."\";";
    $result = $dbConn->query($sql);
    if (($result != null) && ($result->num_rows > 0))
    {
        $row = $result->fetch_assoc();
        $User['id']            = $row['id'];
        $User['name']          = $row['name'];
        $User['surname']       = $row['surname'];
        $User['email']         = $row['email'];
        $User['telephone']     = $row['telephone'];
        $User['account']       = $row['account'];
        $User['pwsha1']        = $row['pwsha1'];
        $loaded=true;
    }/*if found*/
    db_r_close ($dbConn);
    return $loaded;    
}/*UserLoadByEmail()*/

function UserLoadById($Id, &$User)
{
    $loaded = false;
    $dbConn = db_r_connect ();
    $sql = "SELECT id,name,surname,email,telephone,account,pwsha1 FROM user WHERE id=\"".$Id."\";";
    $result = $dbConn->query($sql);
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $User['id']            = $row['id'];
        $User['name']          = $row['name'];
        $User['surname']       = $row['surname'];
        $User['email']         = $row['email'];
        $User['telephone']     = $row['telephone'];
        $User['account']       = $row['account'];
        $User['pwsha1']        = $row['pwsha1'];
        $loaded=true;
    }/*if found*/
    db_r_close ($dbConn);
    return $loaded;
}/*UserLoadById()*/

function UserValidName ($NameString)
{
    if (empty ($NameString))
        return false;

    return true;
}/*UserValidName()*/

function UserValidEmail ($NameString)
{
    if (empty ($NameString))
        return false;

    return true;
}/*UserValidEmail()*/

function UserValidTelephone ($NameString)
{
    if (empty ($NameString))
        return false;

    return true;
}/*UserValidTelephone()*/

function UserValidAccount ($pAccountID)
{
    if (empty ($pAccountID))
        return true;//allowed with no account

    if (!MemberAccountExists ($pAccountID))
        return false;

    return true;
}/*UserValidAccount()*/

function UserLogin ($Email, $Password, &$ErrorMessage)
{
    $ErrorMessage = "";
    if (!UserLoadByEmail ($Email, $ExistingUser, $ErrorMessage))
        return false;

    if (sha1($Password) != $ExistingUser['pwsha1'])
    {
        $ErrorMessage = "Wrong password.";
        return false;
    }//if

    //logged in, set login details
    $_SESSION['user'] = $ExistingUser;
    return true;
}/*UserLogin()*/

function UserLogout ()
{
    unset ($_SESSION['user']);
    return true;
}/*UserLogout()*/

function UserIsLoggedIn ()
{
    return isset ($_SESSION['user']);
}/*UserLogout()*/


?>