<?php

	class TestOfPlugin extends WebTestCase{

		private $adminFolder = null;
		private $appFolder = null;
		private $magratheaPluginFolder = null;

		private $localAdminUrl = "http://sample_project.magrathea.platypus/admin.php";

		function setUp(){
			$this->adminFolder = __DIR__."/../Magrathea_admin";
			$this->appFolder = __DIR__."/../app";
			$this->magratheaPluginFolder = __DIR__."/../Magrathea/plugins/";
			mkdir($this->magratheaPluginFolder."testPlugin");
		}
		function tearDown(){
			rmdir($this->magratheaPluginFolder."testPlugin");
		}

		function testInstallPlugin(){
			$this->post(
				$this->localAdminUrl."?page=plugin_install",
				array("pluginFolder" => "testPlugin")
				);
			echo "looking for ".$this->appFolder."/plugins/testPlugin";
			$this->assertTrue( is_dir( $this->appFolder."/plugins/testPlugin") );
		}

	}



?>