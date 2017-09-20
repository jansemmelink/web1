<?php
include_once "../php/event.php";
include_once "../php/form.php";
include_once "../php/member.php";
include_once "../php/page.php";

if (!isset ($_GET['event'])) {
  PageError("Missing event in URL");
}/*if no event specified*/

if (!EventLoad($_GET['event'], $Event)) {
  PageError("Unknown event in URL");
}/*if invalid event*/

$Err = "";
$hasErr = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //make sure required fields were populated
    if (!empty($_POST["idoracc"])) {
        $IDorAcc = FormSanitiseInput($_POST["idoracc"]);
        if (MemberLoad($IDorAcc, $Member))
        {
            //LOADED membership
            
            //see if already entered: TODO
            
            //... show enter page with membership already loaded...
            header('Location: /enter.php?event='.$_GET['event'].'&member='.$Member['id'], true, 301);
            exit();
        }/*if loaded*/
    }
}/*if POSTED*/

//not posted: show form below for a new entry
?>

<html>
  <body>
    <h1>Lidmaatskap</h1>
    <p>Elke lid het 'n registrasie nommer wat bestaan uit een letter gevolg deur syfers, byvoorbeeld A00000. Dit word op jou rekening state getoon.</p>
    <p>As jy jou registrasie nommer ken, probeer dit hier onder, of <a href="enter.php?event=<?php echo $Event['id'];?>">vul self jou inligting in</a>.</p>
    <form method="post" action="member_select.php?event=<?php echo $_GET['event'];?>">
      <table>
        <tr><td align="right">Lidmaatskap of Rekening Nr:</td><td><input type="text" name="idoracc" value=""/></td></tr>
        <tr>
          <td colspan="2">
            <input type="submit" value="Teken in"/>
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>