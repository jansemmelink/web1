<?php
include_once "../php/page.php";
include_once "../php/user.php";
UserLogout ();

PageStart ("Log Out");
?>
<h1>Good bye</h1>
<p>You have been logged out.</p>
<?php
PageEnd ();
?>