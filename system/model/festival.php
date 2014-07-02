<?php
	namespace Model;

	use Framework\Base\Model;

	class Festival extends Model{

		private $sNaam;

		public function __construct($sNaam, $iId = -1, $sIdToken = ''){

			parent::__construct($iId, $sIdToken);

			$this->sNaam    = $sNaam;
		}

		public function getLabel(){
			return $this->getNaam();
		}

		public function getNaam(){
			return $this->sNaam;
		}

		public function setNaam($sNaam){
			$this->sNaam = $sNaam;
		}
	}