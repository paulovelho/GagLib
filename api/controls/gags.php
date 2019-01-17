<?php

class GagsApi extends MagratheaApiControl {

	public function __construct() {
		$this->model = "Gag";
		$this->service = new GagControl();
	}

	public function Breaker() {
		$g = $this->service->GetBreaker();
		return $g->text;
	}

}

?>
