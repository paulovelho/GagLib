#!/bin/bash
clear

echo -e "MAGRATHEA ADMIN LOGIN DB-LESS \n"
echo -e "by Paulo Henrique Martins - Platypus Technology \n\n"
echo -e "Creating the simplest admin login system without necessity of any table or any database\n"
echo -e "We are now going through the proccess of creating the project! Let's go!\n\n"
sleep 1

mkdir -p database
chmod 777 database

echo -e "\ncreating file database/adminlogin_data.magratheaDB...\n"
echo -e "\t(this is the database file, once we don't connect to any db)\n"
cat <<EOF >database/adminlogin_data.magratheaDB
// generated by MagratheaAdminLogin

[dev]
  magrathea_user = '[
    { "email": "user@user.com", "password": "password123" },
    { "email": "admin@admin.com", "password": "password456" }
  ]'
EOF

echo -e "\ncreating file app/Views/login.html...\n"
echo -e "\t(this is the login html page)\n"
cat <<EOF >app/Views/login.html
<html>
  <head>
    <title>Magrathea Admin</title>
    <style>
  body {
    font: 13px/20px 'Lucida Grande', Tahoma, Verdana, sans-serif;
    color: #404040;
    background: #AAA;
  }
  .container {
    margin: 80px auto;
    width: 640px;
  }
  .login {
    background-color: #FFF;
    padding: 20px;
  }
    .login h1 {
      text-align: center;
      width: 100%;
    }
    .login input {
      width: 100%;
      font-family: 'Lucida Grande', Tahoma, Verdana, sans-serif;
      font-size: 14px;
      margin: 5px;
      padding: 0 10px;
      height: 34px;
      color: #404040;
      background: white;
      border: 1px solid;
      border-color: #c4c4c4 #d1d1d1 #d4d4d4;
      border-radius: 2px;
      outline: 5px solid #eff4f7;
      }
      .login .bt {
      padding: 0 18px;
      height: 29px;
      font-size: 12px;
      font-weight: bold;
      color: #000;
      text-shadow: 0 1px #e3f1f1;
      background: #CCC;
      border: 1px solid;
      border-color: #b4ccce #b3c0c8 #9eb9c2;
      border-radius: 16px;
      outline: 0;
      }
    .message { 
      color: red;
    }
    </style>
  </head>
  <body>

  <section class="container">
    <div class="login">
      <h1>Magrathea Login</h1>
      <form method="post" action="login.php">
        <p><input type="text" name="email" value="" placeholder="e-mail"></p>
        <p><input type="password" name="password" value="" placeholder="password"></p>
        <p class="message"><?=$error_message?></p>
        <p class="submit"><input type="submit" class="bt" name="commit" value="Login"></p>
      </form>
    </div>
  </section>

  </body>
</html>
EOF

echo -e "\ncreating file app/login.php...\n"
echo -e "\t(this is where magic happens)\n"
cat <<EOF >app/login.php
<?php
  require("inc/global.php");

  \$email = @\$_POST["email"];
  \$pass = @\$_POST["password"];

  \$env = MagratheaConfig::Instance()->GetEnvironment();

  \$db = new MagratheaConfigFile();
  \$db->setPath("../database/")->setFile("adminlogin_data.magratheaDB");
  \$db->createFileIfNotExists();
  \$section = \$db->getConfigSection(\$env);
  \$users = \$section["magrathea_user"];

  if(!empty(\$users)){
    \$users = html_entity_decode(\$users);
    \$users = json_decode(\$users); 
        } else {
                die("users are not defined");
  } 

  foreach (\$users as \$u) {
    if(\$u->email == \$email && \$u->password == \$pass)
      \$_SESSION["magrathea_user"] = \$email;
  }

  if(empty(\$_SESSION["magrathea_user"]))
    header("Location: admin.php?error=login_error");
  else 
    header("Location: admin.php");
?>
EOF

echo -e "\ncreating file app/admin.php...\n"
echo -e "\t(a new approach to an old friend)\n"
cat <<EOF >app/admin.php
<?php
  include("inc/global.php");
  include(\$magrathea_path."/MagratheaAdmin.php"); // $magrathea_path should already be declared

  class MagratheaLoginController extends MagratheaController {
    public static function Login(){
      if(@\$_GET["error"] == "login_error")
        \$error_message = "Login or password incorrect!";
      include "Views/login.html";
    }
  }

  if(!empty(\$_SESSION["magrathea_user"])) {
    \$admin = new MagratheaAdmin(); // adds the admin file
    \$admin->Load(); // load!
  } else {
    MagratheaLoginController::Login();
  }

?>
EOF


echo -e "\nDONE!\n"
echo -e "\n\tThat's it! To edit the permissions, just edit database/adminlogin_data.magratheaDB file\n"
echo -e "\t - - here, here: vi database/adminlogin_data.magratheaDB \n"
