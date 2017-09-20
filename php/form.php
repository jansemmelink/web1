<?php
function FormSanitiseInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}/*FormSanitiseInput()*/
?>