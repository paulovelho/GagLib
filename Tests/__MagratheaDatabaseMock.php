<?php

class MagratheaDatabaseMock extends MagratheaDatabase {
	public $methods = [];
	public $lastMethod = null;
	public $queries = [];
	public $params = [];
	public $lastQuery = null;
	public $lastParams = null;
	private $calls = 0;

	public function __construct() {}

	private function Historize() {
		$this->calls ++;
		array_push($this->methods, $this->lastMethod);
		array_push($this->queries, $this->lastQuery);
		array_push($this->params, $this->lastParams);
	}

	public function Reset() {
		$this->methods = [];
		$this->lastMethod = null;
		$this->queries = [];
		$this->params = [];
		$this->lastQuery = null;
		$this->lastParams = null;
		$this->calls = 0;
		return $this;
	}

	public function Query($sql){
		$this->lastMethod = __FUNCTION__;
		$this->lastQuery = trim($sql);
		$this->lastParams = array();
		$this->Historize();
		return $this->LookForReturn([]);
	}
	public function QueryAll($sql){
		$this->lastMethod = __FUNCTION__;
		$this->lastQuery = trim($sql);
		$this->lastParams = array();
		$this->Historize();
		return $this->LookForReturn([]);
	}
	public function QueryRow($sql){
		$this->lastMethod = __FUNCTION__;
		$this->lastQuery = trim($sql);
		$this->lastParams = array();
		$this->Historize();
		return $this->LookForReturn();
	}
	public function QueryOne($sql){
		$this->lastMethod = __FUNCTION__;
		$this->lastQuery = trim($sql);
		$this->lastParams = array();
		$this->Historize();
		return $this->LookForReturn();
	}
	public function QueryTransaction($query_array){
		$this->lastMethod = __FUNCTION__;
		$this->lastQuery = $query_array;
		$this->Historize();
		return null;
	}
	public function PrepareAndExecute($query, $arrTypes, $arrValues){
		$this->lastMethod = __FUNCTION__;
		$this->lastQuery = $query;
		$this->lastParams = $arrValues;
		$this->Historize();
		return $this->LookForReturn();
	}

	private $returns = [];
	private function LookForReturn($default=null) {
		return array_key_exists($this->calls, $this->returns) 
			? $this->returns[$this->calls] 
			: $default;
	}

	public function ReturnOnCall($n, $ret) {
		$this->returns[$n+1] = $ret;
		return $this;
	}


}


?>
