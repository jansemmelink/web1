<?php
include_once "user.php";

function PageError($pHeadingS, $pMessageS="")
{
    PageStart ();
    echo "<h1>ERROR: $pHeadingS</h1>";
    echo "<p>$pMessageS</p>";
    PageEnd ();
    die();
}

function PageConfirm($pHeadingS, $pMessageS="")
{
    PageStart ();
    echo "<h1>$pHeadingS</h1>";
    echo "<p>$pMessageS</p>";
    PageEnd ();
    die();
}

function PageStart($pTitleS="")
{
    echo "<html>";
    echo "  <head>";
    if (!empty ($pTitleS)) echo "    <title>$pTitleS</title>";
    echo "  </head>";
    echo "  <body>";
    echo "    <div id='header'>";
    echo "      <ul>";
    echo "        <li><a href='index.php'>Home</a></li>";
    if (!UserIsLoggedIn ())
    {
        echo "        <li><a href='login.php'>Log In</a></li>";
        echo "        <li><a href='register.php'>Register</a></li>";
    }
    else
    {
        echo "        <li><a href='profile.php'>".$_SESSION['user']['name']." ".$_SESSION['user']['surname']."</a></li>";
        if ($_SESSION['user']['account'] != "")
        echo "        <li><a href='account.php'>Account</a></li>";
        echo "        <li><a href='logout.php'>Log Out</a></li>";
    }
    echo "      </ul>";
    echo "    </div>";
    echo "    <div id='contents'>";
}/*PageStart()*/

function PageEnd()
{
    echo "    </div>";
    echo "  </body>";
    echo "</html>";
}/*PageEnd()*/