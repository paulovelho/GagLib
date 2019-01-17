<?php

	include("../app/inc/global.php");
  MagratheaModel::IncludeAllModels();

	include($magrathea_path."/MagratheaApi.php");
  include("controls/gags.php");
	include("controls/origins.php");

  $originControl = new OriginsApi();
  $gagControl = new GagsApi();

  $api = MagratheaApi::Start()
  	->AllowAll()
  	->Crud("origins", $originControl)
    ->Add("GET", "gags/random", $gagControl, "Random")
    ->Add("GET", "breaker", $gagControl, "Breaker");

  if($_GET["magrathea_control"] == "debug") {
	  $api->Debug();
  } else {
	  $api->Run();
  }

?>
