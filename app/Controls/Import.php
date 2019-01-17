<?php

class ImportController extends BaseControl {

	private function LoadDataFile($file) {
		$file = file_get_contents(__DIR__."/../../data/".$file);
		$f = explode("\n", $file);
		$f = array_filter($f);
		return $f;
	}

	private function AddBreaker($question) {
		$gag = new Gag();
		$gag->origin_id = 7;
		$gag->tags = "basic";
		$gag->text = $question;
		$gag->Insert();
		echo "added: ".$question." <br/>";
	}
	public function Breakers() {
		die;
		$f = $this->LoadDataFile("breakers.txt");
		foreach ($f as $gag) {
			$this->AddBreaker($gag);
		}
	}


}

?>
