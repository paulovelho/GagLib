<?php

	class TestOfMagratheaRoute extends UnitTestCase{

		function setUp(){
			$_GET["magrathea_control"] = null;
			$_GET["magrathea_action"] = null;
			$_GET["magrathea_params"] = null;
		}
		function tearDown(){
		}

/*
		function testDefaultRoutes(){
			echo "testing MagratheaRoutes: defaults... <br/>";
			MagratheaRoute::Instance()->Route($ctrl, $act);
			$this->assertEqual($ctrl, "home");
			$this->assertEqual($act, "index");
		}

		function testDefaultAction(){
			echo "testing MagratheaRoutes: default actions... <br/>";
			$_GET["magrathea_control"] = "Internal";
			MagratheaRoute::Instance()->Route($control, $action);
			$this->assertEqual($control, "internal");
			$this->assertEqual($action, "index");
		}
*/

		function testCreatingRoutesRules(){
			echo "testing MagratheaRoutes: redirecting routes... <br/>";
			$routes = array(
				"Contato" => "Home/Contato", // control to control/action
				"Contato/Enviar" => "Home/EnviarContato", // control/action to control/action
				"Filmes" => "Movies", // only controller
				"Awards/Oscar" => "Home/Oscar"
			);
			MagratheaRoute::Instance()->SetRoute($routes);
			// rule 1: control to control/action
			$control = null; $action = null;
			$_GET["magrathea_control"] = "Contato";
			$_GET["magrathea_action"] = null;
			$_GET["magrathea_params"] = null;
			MagratheaRoute::Instance()->Route($control, $action);
			$this->assertEqual($control, "home");
			$this->assertEqual($action, "contato");
			// rule 2: control/action to control/action
			$control = null; $action = null;
			$_GET["magrathea_control"] = "Contato";
			$_GET["magrathea_action"] = "Enviar";
			$_GET["magrathea_params"] = null;
			MagratheaRoute::Instance()->Route($control, $action);
			$this->assertEqual($control, "home");
			$this->assertEqual($action, "enviarcontato");
			// rule 3: control
			$control = null; $action = null;
			$_GET["magrathea_control"] = "Filmes";
			$_GET["magrathea_action"] = null;
			$_GET["magrathea_params"] = null;
			MagratheaRoute::Instance()->Route($control, $action);
			$this->assertEqual($control, "movies");
			$this->assertEqual($action, "index");
			// rule 3: only controller, but with action
			$control = null; $action = null;
			$_GET["magrathea_control"] = "Filmes";
			$_GET["magrathea_action"] = "Matrix";
			$_GET["magrathea_params"] = null;
			MagratheaRoute::Instance()->Route($control, $action);
			$this->assertEqual($control, "movies");
			$this->assertEqual($action, "matrix");
			// rule 4: one single action per controller
			$control = null; $action = null;
			$_GET["magrathea_control"] = "Awards";
			$_GET["magrathea_action"] = "Oscar";
			$_GET["magrathea_params"] = null;
			MagratheaRoute::Instance()->Route($control, $action);
			$this->assertEqual($control, "home");
			$this->assertEqual($action, "oscar");
			$control = null; $action = null;
			$_GET["magrathea_control"] = "Awards";
			$_GET["magrathea_action"] = "GoldenGlobe";
			$_GET["magrathea_params"] = null;
			MagratheaRoute::Instance()->Route($control, $action);
			$this->assertEqual($control, "awards");
			$this->assertEqual($action, "goldenglobe");
		}

		function testChangeDefaultRoutes(){
			echo "testing MagratheaRoutes: changing default routes... <br/>";
			$route = MagratheaRoute::Instance();
			$route->Defaults("H", "I");
			$route->Route($control, $action);
			$this->assertEqual($control, "h");
			$this->assertEqual($action, "i");
		}
	}
?>