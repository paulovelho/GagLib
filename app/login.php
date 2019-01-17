<?php
  require("inc/global.php");

  $email = @$_POST["email"];
  $pass = @$_POST["password"];

  $env = MagratheaConfig::Instance()->GetEnvironment();

  $db = new MagratheaConfigFile();
  $db->setPath("../database/")->setFile("adminlogin_data.magratheaDB");
  $db->createFileIfNotExists();
  $section = $db->getConfigSection($env);
  $users = $section["magrathea_user"];

  if(!empty($users)){
    $users = html_entity_decode($users);
    $users = json_decode($users); 
        } else {
                die("users are not defined");
  } 

  foreach ($users as $u) {
    if($u->email == $email && $u->password == $pass)
      $_SESSION["magrathea_user"] = $email;
  }

  if(empty($_SESSION["magrathea_user"]))
    header("Location: admin.php?error=login_error");
  else 
    header("Location: admin.php");
?>
