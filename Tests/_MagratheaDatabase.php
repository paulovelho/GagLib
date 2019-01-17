<?php

	class TestOfDatabase extends UnitTestCase{

		function setUp(){

		}
		function tearDown(){

		}

		// is Database connecting?
		function testConnectDatabase(){
			echo "testing MagratheaDatabase db connection... <br/>";
			$env = MagratheaConfig::Instance()->GetEnvironment();
			$configSection = MagratheaConfig::Instance()->GetConfigSection($env);
			$magdb = MagratheaDatabase::Instance();
			$magdb->SetConnection($configSection["db_host"], $configSection["db_name"], $configSection["db_user"], $configSection["db_pass"]);
			$this->assertTrue( $magdb->OpenConnectionPlease() );	
		}

	}

	class TestOfDatabaseActions extends UnitTestCase {

		private $magdb = null;

		function setUp(){
			$env = MagratheaConfig::Instance()->GetEnvironment();
			$configSection = MagratheaConfig::Instance()->GetConfigSection($env);
			$this->magdb = MagratheaDatabase::Instance();
			$this->magdb->SetConnection($configSection["db_host"], $configSection["db_name"], $configSection["db_user"], $configSection["db_pass"]);
		}
		function tearDown(){

		}

		// tests if queries as an array
		function testSelectQueryAll(){
			echo "testing MagratheaDatabase QueryAll... <br/>";
			$query = "SELECT 1 AS ok";
			$result = $this->magdb->QueryAll($query);
			$this->assertIsA($result[0], "array");
		}

		// tests if queries as a row
		function testSelectQueryRow(){
			echo "testing MagratheaDatabase QueryRow... <br/>";
			$query = "SELECT 1 AS ok";
			$result = $this->magdb->QueryRow($query);
			$this->assertIsA($result, "array");
		}

		// tests if queries as a single result
		function testSelectQueryOne(){
			echo "testing MagratheaDatabase QueryOne... <br/>";
			$query = "SELECT 1 AS ok";
			$result = $this->magdb->QueryOne($query);
			$this->assertEqual($result, 1);
		}

		// tests if queries as an ordered row
		function testSelectQueryRowObject(){
			echo "testing MagratheaDatabase QueryRowObject... <br/>";
			$this->magdb->SetFetchMode("object");
			$query = "SELECT 1 AS ok";
			$result = $this->magdb->QueryRow($query);
			$this->assertEqual($result->ok, 1);
		}

		// tests if queries as an assoc row
		function testSelectQueryRowAssoc(){
			echo "testing MagratheaDatabase QueryRowAssoc... <br/>";
			$this->magdb->SetFetchMode("assoc");
			$query = "SELECT 1 AS ok";
			$result = $this->magdb->QueryRow($query);
			$this->assertEqual($result["ok"], 1);
		}

		function testIfAllColumnNamesComesInLowerCase(){
			echo "testing MagratheaDatabase being sure all database keys returns in lower case... <br/>";
			$this->magdb->SetFetchMode("assoc");
			$query = "SELECT 1 AS UppErCasEvar";
			$result = $this->magdb->QueryRow($query);
			$this->assertEqual($result["uppercasevar"], 1);

		}

	}


?>