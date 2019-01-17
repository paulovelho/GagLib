<?php

class BaseControl extends MagratheaController {

  public static function Go404(){
    global $Smarty;
    die("404");
    $Smarty->display("404.html");
    return;
  }

  public static function Kill(){
    global $Smarty;
    $Smarty->display("error.html");
    return;
  }

}

?>
