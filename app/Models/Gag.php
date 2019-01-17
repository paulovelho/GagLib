<?php

include(__DIR__."/Base/GagBase.php");

class Gag extends GagBase {
	// your code goes here!
}

class GagControl extends GagControlBase {

	public function GetBreaker() {
		$origin_id = 7;
		$query = MagratheaQuery::Select()
			->Obj("Gag")
			->Where( array("origin_id" => $origin_id) )
			->Limit(1)
			->Order("RAND()");

		return $this->Run($query)[0];

	}

}

?>