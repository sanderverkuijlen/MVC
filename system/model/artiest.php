<?php
	namespace Model;

	use Framework\Base\Model;

	class Artiest extends Model{

		private $sNaam;
		private $iFestivalId;

		public function __construct($sNaam, $iFestivalId, $iId = -1, $sIdToken = ''){

			parent::__construct($iId, $sIdToken);

			$this->sNaam        = $sNaam;
			$this->iFestivalId  = $iFestivalId;
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

		public function getFestivalId(){
			return $this->iFestivalId;
		}

		public function setFestivalId($iFestivalId){
			$this->iFestivalId = $iFestivalId;
		}
	}