<?php

	class TestMagratheaModel extends UnitTestCase{

		private $mockDb;

		function setUp(){
			$this->mockDb = new MagratheaDatabaseMock();
			MagratheaDatabase::Mock($this->mockDb);
		}
		function tearDown(){
//			MockMe::truncateTables();
		}

		// test simple query:
		function testCreateObject(){
			$origin = new Origin();
			$origin->name = "twitter";
			$origin->Insert();
			$sql = $this->mockDb->lastQuery;
			$params = $this->mockDb->lastParams;

			$this->assertTrue( preg_match("/INSERT INTO origins/", $sql) );
			$this->assertEqual("twitter", $params["name"]);
		}

		// test simple query:
		function testUpdateObject(){
			$origin = new Origin();
			$origin->id = 7;
			$origin->name = "idea";
			$origin->Update();
			$sql = $this->mockDb->lastQuery;
			$params = $this->mockDb->lastParams;

			$this->assertTrue( preg_match("/UPDATE origins SET/", $sql) );
			$this->assertTrue( preg_match("/WHERE id=/", $sql) );
			$this->assertEqual("idea", $params["name"]);
			$this->assertEqual(7, $params["id"]);
		}

		// test simple query:
		function testDeleteObject(){
			$origin = new Origin();
			$origin->id = 13;
			$origin->Delete();
			$sql = $this->mockDb->lastQuery;
			$params = $this->mockDb->lastParams;

			$this->assertTrue( preg_match("/DELETE FROM origins/", $sql) );
			$this->assertTrue( preg_match("/WHERE id=/", $sql) );
			$this->assertEqual(13, $params["id"]);
		}


	}

?>