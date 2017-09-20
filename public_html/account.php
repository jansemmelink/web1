<?php
include_once "../php/form.php";
include_once "../php/user.php";
include_once "../php/page.php";

if (!UserIsLoggedIn ())
    PageError ("Access Denied", "You must log in to see family settings.");

if ($_SESSION['user']['account'] == "")
    PageError ("Account not set. Update you profile account to see your family settings.");

function memberShowInList($pMember)
{
    ?>
    <tr>
        <td><?php echo $pMember['id'];?></td>
        <td><?php echo $pMember['name'];?></td>
        <td><?php echo $pMember['surname'];?></td>
        <td><?php echo $pMember['gender'];?></td>
        <td><?php echo $pMember['groupname'];?></td>
    </tr>
    <?php
}/*memberShowInList()*/
    
//show list of members on this account
PageStart ("Family");
?>
<h1>Family</h1>
<p>These members are linked to your account.</p>
<table>
<tr class="table_header">
    <td>Reg Nr</td>
    <td>Name</td>
    <td>Surname</td>
    <td>Gender</td>
    <td>Group</td>
</tr>
<?php MemberCallForAccount($_SESSION['user']['account'], 'memberShowInList');?>
</table>

<?php
PageEnd();
?>
