<?php
include_once "../php/page.php";
include_once "../php/event.php";

function eventShowInList($pEvent)
{
    ?>
    <tr>
        <td><?php echo $pEvent['org'];?></td>
        <td><a href="event.php?event=<?php echo $pEvent['id'];?>"><?php echo $pEvent['name'];?></a></td>
        <td><?php echo $pEvent['venue'];?></td>
        <td>
            <?php
                if ($pEvent['start']==$pEvent['end'])
                    echo $pEvent['start'];
                else
                    echo "From ".$pEvent['start']." to ".$pEvent['end'];
            ?>
        </td>
        <td>
            <?php
                if ($pEvent['entries_until'] >= date())
                    echo "<a href='enter_members.php?event=".$pEvent['id']."'>Enter</a>";
                else   
                    echo "Entries closed on ".$pEvent['entries_until'];
            ?>
        </td>
    </tr>
    <?php
}/*eventShowInList()*/
    
PageStart ("Members");
?>
    <h1>Members</h1>

    <?php
    if (!UserIsLoggedIn ())
    {
        ?>
        <p>You need to login or register to access the contents of this site.</p>
        <?php
    }//if not logged in
    else
    {
        ?>
        <h2>Current Events</h2>
        <table>
            <tr class="table_header"><td>Organisation</td><td>Event</td><td>Where</td><td>When</td><td>Action</td></tr>
            <?php EventCall ('eventShowInList'); ?>
        </table>     

        <ul>
          <li><a href="member_select.php?event=aingiyai3jah8uH">Midstream Voortrekkers - Kommandokamp 2017</a></li>
        </ul>
        <?php
    }/*if logged in*/
PageEnd();
?>