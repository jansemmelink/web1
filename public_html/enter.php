<?php
include_once "../php/form.php";
include_once "../php/entry.php";
include_once "../php/event.php";
include_once "../php/member.php";
include_once "../php/page.php";

if (!isset ($_GET['event'])) {
  PageError("Missing event in URL");
}/*if no event specified*/

if (!EventLoad($_GET['event'], $Event)) {
  PageError("Unknown event in URL");
}/*if invalid event*/

$Member['id'] = "";
$Member['name'] = "";
$Member['surname'] = "";
$Member['gender'] = "";
$Member['groupname'] = "";
$Member['account'] = "";
if (isset ($_GET['member'])) {
  MemberLoad($_GET['member'], $Member);
}/*if specified member*/


$nameErr = "";
$surnameErr = "";
$groupErr = "";
$genderErr = "";
$transportErr = "";
$hasErr = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //make sure required fields were populated
  if (empty($_POST["name"])) {
    $nameErr = "Naam nie verskaf nie";
    $hasErr = true;
  } else {
    $name = FormSanitiseInput($_POST["name"]);
  }

  if (empty($_POST["surname"])) {
    $surnameErr = "Van nie verskaf nie";
    $hasErr = true;
  } else {
    $surname = FormSanitiseInput($_POST["surname"]);
  }
  
  if (empty($_POST["groupname"])) {
    $groupErr = "Nog nie group gekies nie";
    $hasErr = true;
  } else {
    $groupname = FormSanitiseInput($_POST["groupname"]);
  }
  
  if (empty($_POST["gender"])) {
    $genderErr = "Nog nie geslag gekies nie";
    $hasErr = true;
  } else {
    $gender = FormSanitiseInput($_POST["groupname"]);
  }
  
  if (!$hasErr)
  {//function EntryCreate($pEventID, $pMemberID, $pNameS, $pSurnameS, $pGender, $pGroupName, $pTransport)
    if (EntryCreate($_GET['event'], $_POST["membership_nr"], $_POST["name"], $_POST["surname"], $_POST["gender"], $_POST["groupname"], $_POST["transport"]))
        PageError ("Sorry. Entry Failed.");

    PageConfirm ("Entry Created");
  }/*if no errors*/
}/*if POSTED*/

//not posted: show form below for a new entry
?>

<html>
  <body>
    <h1><?php echo $Event['name'];?></h1>
    <p>
      <?php
      echo "Vanaf ".$Event['start']." tot ".$Event['end']."<br/>";
      ?>
    </p>
    <form method="post" action="enter.php?event=<?php echo $_GET['event'];?>">
      <table>
        <tr><td align="right">Naam</td><td><input type="text" name="name" value="<?php echo $Member['name'];?>"/></td></tr>
        <tr><td align="right">Van</td><td><input type="text" name="surname" value="<?php echo $Member['surname'];?>"/></td></tr>
        <tr><td align="right">Lidmaatskap Nr</td><td><input type="text" name="membership_nr" value="<?php echo $Member['id'];?>"/></td></tr>
        <tr><td align="right">Graad</td><td>
          <select name="groupname">
            <option value="">Kies...</option>
            <option value="grR" <?php if ($Member['groupname']=="R") echo "selected";?>>R</option>
            <option value="gr1" <?php if ($Member['groupname']=="1") echo "selected";?>>1</option>
            <option value="gr2" <?php if ($Member['groupname']=="2") echo "selected";?>>2</option>
            <option value="gr3" <?php if ($Member['groupname']=="3") echo "selected";?>>3</option>
            <option value="gr4" <?php if ($Member['groupname']=="4") echo "selected";?>>4</option>
            <option value="gr5" <?php if ($Member['groupname']=="5") echo "selected";?>>5</option>
            <option value="gr6" <?php if ($Member['groupname']=="6") echo "selected";?>>6</option>
            <option value="gr7" <?php if ($Member['groupname']=="7") echo "selected";?>>7</option>
            <option value="gr8" <?php if ($Member['groupname']=="8") echo "selected";?>>8</option>
            <option value="gr9" <?php if ($Member['groupname']=="9") echo "selected";?>>9</option>
            <option value="gr10" <?php if ($Member['groupname']=="10") echo "selected";?>>10</option>
            <option value="gr11" <?php if ($Member['groupname']=="11") echo "selected";?>>11</option>
            <option value="gr12" <?php if ($Member['groupname']=="12") echo "selected";?>>12</option>
            <option value="gr12" <?php if ($Member['groupname']=="Offisier") echo "selected";?>>Offisier</option>
            <option value="gr12" <?php if ($Member['groupname']=="Heemraad") echo "selected";?>>Heemraad</option>
          </select></td>
        </tr>
        <tr><td align="right">Geslag</td><td>
          <input type="radio" name="gender" value="male" <?php if ($Member['gender']=="M") echo "checked";?>>Seun/Man</input><br>
          <input type="radio" name="gender" value="female" <?php if ($Member['gender']=="V") echo "checked";?>>Dogter/Vrou</input><br>
        </td></tr>
        <tr><td align="right">Vervoer</td><td>
          <input type="radio" name="transport" value="bus" checked>Ry met die bus</input><br>
          <input type="radio" name="transport" value="own">Eie vervoer</input><br>
        </td></tr>
        <tr>
          <td colspan="2">
            <input type="submit" value="Skryf In"/>
          </td>
        </tr>
      </table>
    </form>

    <p>Kliek <a href="member_select.php?event=<?php echo $Event['id'];?>">hier</a> as jy nou jou nommer onthou of 'n ander nommer wil laai...</p>
  </body>
</html>