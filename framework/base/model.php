<?php
	namespace Framework\Base;

	use Framework\Exception;

	abstract class Model{

		private $iId;
		private $sIdToken;

		public function __construct($iId = -1, $sIdToken = ''){
			$this->iId      = $iId;
			$this->sIdToken = $sIdToken;
		}

		abstract public function getLabel();


		public function getId(){
			return $this->iId;
		}

		public function setId($iId){
			$this->iId = $iId;
		}

		public function getIdToken(){
			return $this->sIdToken;
		}

		public function setIdToken($sIdToken){
			$this->sIdToken = $sIdToken;
		}
	}