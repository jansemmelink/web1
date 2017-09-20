<?php
include_once "../php/form.php";
include_once "../php/entry.php";
include_once "../php/event.php";
include_once "../php/member.php";
include_once "../php/page.php";

if (!UserIsLoggedIn ())
  PageError ("Access Denied", "You need to log in.");

if ($_SESSION['user']['account'] == "")
  PageError ("Account not set. Update you profile with account information.");

if (!isset ($_GET['event'])) {
  PageError("Missing event in URL");
}/*if no event specified*/

if (!EventLoad($_GET['event'], $Event)) {
  PageError("Unknown event in URL");
}/*if invalid event*/

function memberShow($pMember)
{
  //write a table row for each member
  echo "<tr>";
  echo "<td>".$pMember['name']." ".$pMember['surname']."</td>";

  if (!EntryLoad ($Event['id'], $pMember['id'], $Entry))
  {
    //TODO: see if this member is elligible for entry into this event
    //check event groups
    //check event limit on entries
    //check event closing date
    ?>
    <td>
    <form method="post" action="enter_members.php">
      <table>
        <tr><td></td></tr>
        <tr>
          <td colspan="2">
            <input type="submit" value="Enter"/>
          </td>
        </tr>
      </table>
    </form>
    </td>
    <?php
  }//if not yet entered
  else
  {
    //already entered: show entry details
    echo "<td>Already Entered.</td>";
  }//if already entered
  echo "</tr>";
}/*memberShow()*/

PageStart ("Event Entries");
//show entry form for each account member
echo "<h1>".$Event['name']." entries</h1>";
echo "<table>";
MemberCallForAccount($_SESSION['user']['account'], 'memberShow');
echo "</table>";
PageEnd ();