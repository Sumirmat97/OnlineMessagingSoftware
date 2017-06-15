<?php
session_start();

include "../query.php";
$profile = new Profile($_SESSION['id']);

/*Change password*/
$password = $new_Password = $con_Password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $password = test_input($_POST["password"]);
  $new_Password = test_input($_POST["newPassword"]);
  $con_Password = test_input($_POST["conPassword"]);

  if($new_Password != $con_Password)
  {
    echo "*New Password and Confirm Password does not match!!!";
  }

  else {
    $salt = sha1(md5($password));
    $password = md5($salt.$password);
    $result = $profile->getPassword($_SESSION['id']);
    $final = pg_fetch_assoc($result);

    if($password != $final['pass'])
    {
      echo "*Enter correct Password";
    }
    else {
      $salt = sha1(md5($new_Password));
      $new_Password = md5($salt.$new_Password);
      $changed = $profile->changePassword($new_Password);
      if($changed)
      {
        echo "done";
      }
      else {
        echo "not done";
      }
    }
  }
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}



 ?>
