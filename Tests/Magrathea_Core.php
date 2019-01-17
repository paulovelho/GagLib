<pre>
<?php

//	ini_set('display_errors', 1);
//	error_reporting(E_ALL);

	SimpleTest :: prefer(new TextReporter());

	loadMagratheaEnv("dev-test");
  include("Controls/_BaseControl.php");
  MagratheaController::IncludeAllControllers();
  MagratheaModel::IncludeAllModels();

  include("__MagratheaDatabaseMock.php");

	echo "</pre><hr/><br/>";
	echo "Config Tests: [ok]<br/>";
	echo "Logger Tests: [ok]<br/>";
	echo "Database Tests: [ok]<br/>";
	echo "<br/><hr/><br/><pre>";

	include("_MagratheaConfig.php");
	include("_MagratheaLogger.php");
	include("_MagratheaDatabase.php");
	include("_MagratheaModel.php");
	include("_MagratheaQuery.php");
	include("_MagratheaRoutes.php");
	include("_MagratheaApi.php");

?>
</pre>