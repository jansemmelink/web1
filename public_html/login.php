<?php
include_once "../php/form.php";
include_once "../php/user.php";
include_once "../php/page.php";

UserInit ($User);
UserInit ($UserErr);
$hasErr = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //make sure required fields were populated
    if (empty($_POST["email"])) {
        $UserErr['email'] = "E-mail is required";
        $hasErr = true;
    } else {
        $User['email'] = FormSanitiseInput($_POST["email"]);
        if (!filter_var($User['email'], FILTER_VALIDATE_EMAIL)) {
            $UserErr['email'] = "Invalid email format"; 
            $hasErr = true;
        }//if invalid email format
        if (!UserLoadByEmail ($User['email'], $ExistingUser))
        {
            $UserErr['email'] = "Unknown email"; 
            $hasErr = true;
        }//if load failed
    }//if email specified

    if (empty($_POST["password"])) {
        $UserErr['password'] = "Password is required";
        $hasErr = true;
    } else {
        $User['password'] = FormSanitiseInput($_POST["password"]);
    }

    //if valid form contents: create user
    if (!$hasErr)
    {
        if (!UserLogin ($User['email'], $User['password'], $ErrorMessage))
            PageError ("Login failed.", "Incorrect password.");

        // login success
        PageConfirm ("Login Success.", "Welcome back.");
    }/*if no errors*/
}/*if POSTED*/

//not posted: show form below for a new entry
PageStart ("Log In");
?>
    <h1>User Login</h1>
    <form method="post" action="login.php">
      <table>
        <tr><td align="right">Email</td>     <td><input type="text"     name="email"     value="<?php echo $User['email'];?>"/></td><td><?php echo $UserErr['email'];?></td></tr>
        <tr><td align="right">Password</td>  <td><input type="password" name="password"/>                                      </td><td></td></tr>
        <tr>
          <td colspan="2">
            <input type="submit" value="Log In"/>
          </td>
        </tr>
      </table>
    </form>
<?php
PageEnd();
?>