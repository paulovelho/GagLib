<?php

class OriginsApi extends MagratheaApiControl {

	public function __construct() {
		$this->model = "Origin";
		$this->service = new OriginControl();
	}

	public function Delete($params) {
		return "invalid request";
	}

}

?>
