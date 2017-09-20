<?php
include_once "../php/form.php";
include_once "../php/user.php";
include_once "../php/page.php";
include_once "../php/member.php";

UserInit ($User);
UserInit ($UserErr);
$hasErr = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //make sure required fields were populated
  if (empty($_POST["name"])) {
    $UserErr['name'] = "Name is required";
    $hasErr = true;
  } else {
    $User['name'] = FormSanitiseInput($_POST["name"]);
  }
  
  if (empty($_POST["surname"])) {
    $UserErr['surname'] = "Surname is required";
    $hasErr = true;
  } else {
    $User['surname'] = FormSanitiseInput($_POST["surname"]);
  }
  
  if (empty($_POST["email"])) {
    $UserErr['email'] = "E-mail is required";
    $hasErr = true;
  } else {
    $User['email'] = FormSanitiseInput($_POST["email"]);
    if (!filter_var($User['email'], FILTER_VALIDATE_EMAIL)) {
      $UserErr['email'] = "Invalid email format"; 
    }
  }

  if (empty($_POST["telephone"])) {
    $UserErr['telephone'] = "Telephone is required";
    $hasErr = true;
  } else {
    $User['telephone'] = FormSanitiseInput($_POST["telephone"]);
  }

  //account: If specified, must exist
  if (!empty($_POST["account"])) {
    $User['account'] = FormSanitiseInput($_POST["account"]);
    if (!MemberAccountExists ($User['account']))
    {
        $UserErr['account'] = "Account does not exist. Leave empty if not know.";
        $hasErr = true;
    }/*if unknown account*/
  }/*if account specified*/

  //if valid form contents: create user
  if (!$hasErr)
  {
    if (!UserCreate($User, $User, $ErrorMessage))
        PageError ("Failed to register.", $ErrorMessage);

    PageConfirm ("Registered.", "Check your email for account activation.");
  }/*if no errors*/
}/*if POSTED*/

//not posted: show form below for a new entry
PageStart ("Registration");
?>
    <h1>User Registration</h1>
    <form method="post" action="register.php">
      <table>
        <tr><td colspan="3"><h2>Personal Information:</h2></td></tr>
        <tr><td align="right">Name</td>      <td><input type="text"     name="name"      value="<?php echo $User['name'];?>"/></td>      <td><?php echo $UserErr['name'];?></td></tr>
        <tr><td align="right">Surname</td>   <td><input type="text"     name="surname"   value="<?php echo $User['surname'];?>"/></td>   <td><?php echo $UserErr['surname'];?></td></tr>
        <tr><td colspan="3"><h2>Contact Information:</h2></td></tr>
        <tr><td align="right">Email</td>     <td><input type="text"     name="email"     value="<?php echo $User['email'];?>"/></td>     <td><?php echo $UserErr['email'];?></td></tr>
        <tr><td align="right">Telephone</td> <td><input type="text"     name="telephone" value="<?php echo $User['telephone'];?>"/></td> <td><?php echo $UserErr['telephone'];?></td></tr>
        <tr><td colspan="3"><h2>Account:</h2><p>Specify your account number if you have an existing account statement.</p></td></tr>
        <tr><td align="right">Account</td>   <td><input type="text"     name="account"   value="<?php echo $User['account'];?>"/></td>   <td><?php echo $UserErr['account'];?></td></tr>
        <tr>
          <td colspan="2">
            <input type="submit" value="Register"/>
          </td>
        </tr>
      </table>
    </form>
<?php
PageEnd();
?>