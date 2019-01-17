<?php

	class TestMagratheaQuery extends UnitTestCase{

		function setUp(){
		}
		function tearDown(){
//			MockMe::truncateTables();
		}

		// test simple query:
		function testSimpleQuery(){
			echo "testing query: simplequery... <br/>";
			$query = MagratheaQuery::Create()->Obj("Origin");
			$sql = $query->SQL();
			$this->assertTrue( preg_match("/SELECT (.*) FROM origins/", $sql) );
		}

		// test simple query:
		function testWhere(){
			echo "testing query: simplequery... <br/>";
			$query = MagratheaQuery::Create()
				->Obj("Origin")
				->Where(array("name" => "twitter"));
			$sql = $query->SQL();
			$this->assertTrue( preg_match("/SELECT (.*) FROM origins WHERE/", $sql) );
			$this->assertTrue( preg_match("/name = 'twitter'/", $sql) );
		}

		// test simple query:
		function testPageAndOrder(){
			echo "testing query: simplequery... <br/>";
			$query = MagratheaQuery::Create()
				->Obj("Gag")
				->Order("source ASC")
				->Limit(20)
				->Page(2);
			$sql = $query->SQL();
			$this->assertTrue( preg_match("/SELECT (.*) FROM gags/", $sql) );
			$this->assertTrue( preg_match("/ORDER BY source ASC/", $sql) );
			$this->assertTrue( preg_match("/LIMIT 40, 20/", $sql) );
		}

		// test joins:
		function testHasOne(){
			echo "testing query: simplequery... <br/>";
			$query = MagratheaQuery::Create()
				->Obj("Gag")
				->HasOne(new Origin(), "origin_id");
			$sql = $query->SQL();
			$this->assertTrue( preg_match("/SELECT (.*) FROM gags/", $sql) );
			$this->assertTrue( preg_match("/INNER JOIN origins/", $sql) );
			$this->assertTrue( preg_match("/gags.origin_id = origins.id/", $sql) );
		}
		function testHasMany(){
			echo "testing query: simplequery... <br/>";
			$query = MagratheaQuery::Create()
				->Obj("Origin")
				->HasMany("gag", "origin_id");
			$sql = $query->SQL();
			$this->assertTrue( preg_match("/SELECT (.*) FROM origins/", $sql) );
			$this->assertTrue( preg_match("/INNER JOIN gags/", $sql) );
			$this->assertTrue( preg_match("/gags.origin_id = origins.id/", $sql) );
		}
		function testBelongsTo(){
			echo "testing query: simplequery... <br/>";
			$query = MagratheaQuery::Create()
				->Obj("Origin")
				->BelongsTo(new Gag(), "origin_id");
			$sql = $query->SQL();
			$this->assertTrue( preg_match("/SELECT (.*) FROM origins/", $sql) );
			$this->assertTrue( preg_match("/INNER JOIN gags/", $sql) );
			$this->assertTrue( preg_match("/gags.origin_id = origins.id/", $sql) );
		}

	}

?>