<?php
 
  include("inc/global.php"); 
  include("Controls/_BaseControl.php");
  MagratheaController::IncludeAllControllers();
  MagratheaModel::IncludeAllModels();


    p_r($_GET);


 
 
  // let's include some of Magrathea's awesome plugins:
  // include("plugins/bootstrap/load.php");
 
 /*
  try {
    MagratheaView::Instance()
    ->IncludeCSS("css/style.css")
    ->IncludeJavascript("javascript/script.js");
  } catch(Exception $ex){
    // probably the file does not exists. What to do now?
  }
*/

  // Magrathea Route will get the path to the correct method in the right class:
  MagratheaRoute::Instance()
    ->Route($control, $action, $params);

  try{
    MagratheaController::Load($control, $action, $params);
  } catch (Exception $ex) {
    p_r($ex);
    Debug($ex);
    BaseControl::Go404();
  }
 
?>
