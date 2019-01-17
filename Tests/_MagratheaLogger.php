<?php

	class TestOfLogger extends UnitTestCase{

		function setUp(){
			$this->deleteLogFile();
		}
		function tearDown(){
		}

		private function GetLogFile(){
			return "log.txt";
		}

		private function deleteLogFile(){
			$site_path = MagratheaConfig::Instance()->GetFromDefault("site_path");
			$logPath = $site_path."/../logs/".$this->GetLogFile();
			@unlink($logPath);
			$this->assertFalse(file_exists($logPath));
		}

		// test log database
		function testLogDatabase(){
			echo "testing MagratheaLogger Log database... <br/>";
			$logFile = $this->GetLogFile();
			$site_path = MagratheaConfig::Instance()->GetFromDefault("site_path");
			$logPath = $site_path."/../logs/".$logFile;

			MagratheaDebugger::Instance()->SetType(MagratheaDebugger::LOG)->SetLogFile($logFile);
			$env = MagratheaConfig::Instance()->GetConfig("general/use_environment");
			$configSection = MagratheaConfig::Instance()->GetConfigSection($env);
			$magdb = MagratheaDatabase::Instance();
			$magdb->SetConnection($configSection["db_host"], $configSection["db_name"], $configSection["db_user"], $configSection["db_pass"]);

			// not log query:
			$query = "SELECT 1 AS ok";
			$magdb->Query($query);
			$this->assertFalse(file_exists($logPath));

			// do log query:
			MagratheaDebugger::Instance()->LogQueries(true);
			$query = "SELECT 1 AS ok";
			$magdb->Query($query);
			$this->assertTrue(file_exists($logPath));

			// goes back to default:
			MagratheaDebugger::Instance()->SetLogFile(null);

		}

		// tests if new lines are added to the log file
		function testIncrementLogger(){
			echo "testing MagratheaLogger Log increment... <br/>";
			$logFile = $this->GetLogFile();
			$site_path = MagratheaConfig::Instance()->GetFromDefault("site_path");
			$logPath = $site_path."/../logs/".$logFile;

			$message = "this nice message for testing";
			MagratheaLogger::Log($message, $logFile);
			$initialFile = file_get_contents($logPath);

			$message2 = "adding a new message for testing";
			MagratheaLogger::Log($message2, $logFile);
			$finalFile = file_get_contents($logPath);

			$this->assertTrue(($finalFile > $initialFile));
		}

	}

?>



