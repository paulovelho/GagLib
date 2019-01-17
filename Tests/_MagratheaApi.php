<?php

	global $magrathea_path;
	include($magrathea_path."/MagratheaApi.php");

	class ControlTestApi {
		public $method;
		public $params;

		public function Create() { $this->method = "Create"; $this->params = $_POST; }
		public function Read($params=null) { $this->method = "Read"; $this->params = $params; }
		public function Update($params) { $this->method = "Update"; $this->params = array("id" => $params["id"], "data" => $_POST); }
		public function Delete($params) { $this->method = "Delete"; $this->params = $params; }
		public function Custom($params) { $this->method = "Custom"; $this->params = $params; }
	}

	class TestMagratheaApi extends UnitTestCase {

		public $api;
		public $control;

		function setUp(){			
			$this->control = new ControlTestApi();
			$this->api = MagratheaApi::Start()
				->Crud("tests", $this->control);
		}
		function tearDown(){
			$_GET = array();
			$_POST = array();
		}


		function testApiCustomUrl() {
			$this->api->Add("GET", "tests/:id1/associatewith/:newId", $this->control, "Custom");
				//->Debug();
			$_SERVER['REQUEST_METHOD'] = "GET";
			$_GET["magrathea_control"] = "tests/id1987/associatewith/id2302";
			$this->api->Run(true);
			$this->assertEqual("Custom", $this->control->method);
			$this->assertEqual("id1987", $this->control->params["id1"]);
			$this->assertEqual("id2302", $this->control->params["newId"]);
		}

		function testApiCrudsRead() {
			$_SERVER['REQUEST_METHOD'] = "GET";
			$_GET["magrathea_control"] = "tests";
			$this->api->Run(true);
			$this->assertEqual("Read", $this->control->method);
			$this->assertNull($this->control->params);
		}

		function testApiCrudsReadObj() {
			$_SERVER['REQUEST_METHOD'] = "GET";
			$_GET["magrathea_control"] = "tests";
			$_GET["magrathea_action"] = "id1987";
			$this->api->Run(true);
			$this->assertEqual("Read", $this->control->method);
			$this->assertEqual("id1987", $this->control->params["id"]);
		}

		function testApiCrudsCreateObj() {
			$_SERVER['REQUEST_METHOD'] = "POST";
			$_GET["magrathea_control"] = "teSts";
			$data = array(
				"name" => "Nicolas Cage",
				"movie" => "Face Off",
				"awards" => "Bets Movie Ever"
			);
			$_POST = $data;
			$this->api->Run(true);
			$this->assertEqual("Create", $this->control->method);
			$this->assertEqual($data, $this->control->params);
		}

		function testApiCrudsUpdateObj() {
			$_SERVER['REQUEST_METHOD'] = "PUT";
			$_GET["magrathea_control"] = "tests";
			$_GET["magrathea_action"] = "id1987";
			$data = array(
				"name" => "Nicolas Cage",
				"movie" => "Face Off",
				"awards" => "Bets Movie Ever"
			);
			$_POST = $data;
			$this->api->Run(true);
			$this->assertEqual("Update", $this->control->method);
			$this->assertEqual(array(
				"id" => "id1987",
				"data" => $data
			), $this->control->params);
		}

		function testApiCrudsDeleteObj() {
			$_SERVER['REQUEST_METHOD'] = "DELETE";
			$_GET["magrathea_control"] = "tests";
			$_GET["magrathea_action"] = "id1987";
			$this->api->Run(true);
			$this->assertEqual("Delete", $this->control->method);
			$this->assertEqual("id1987", $this->control->params["id"]);
		}

	}



?>