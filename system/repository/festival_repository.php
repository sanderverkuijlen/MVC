<?php
	namespace Repository;

	use Framework\Base\Repository;
	use Model\Festival;

	class FestivalRepository extends Repository{

		private $aTmp = [];

		public function __construct(){

			if(array_key_exists('festival', $_SESSION)){
				$this->aTmp = unserialize($_SESSION['festival']);
			}
			else{
				$_SESSION['festival'] = serialize($this->aTmp);
			}
		}

		public function insert(Festival $oFestival){

			$iNewId = 1;

			/* @@var $oOldFestival \Model\Festival */
			foreach($this->aTmp as $oOldFestival){
				if($oOldFestival->getId() >= $iNewId){
					$iNewId = $oOldFestival->getId()+1;
				}
			}

			$oFestival->setId($iNewId);
			$oFestival->setIdToken('a'.$iNewId);

			$this->aTmp[] = $oFestival;

			$_SESSION['festival'] = serialize($this->aTmp);

			return $oFestival;
		}

		public function update(Festival $oFestival){

			for($i = 0; $i < sizeof($this->aTmp); $i++){
				if($this->aTmp[$i]->getId() == $oFestival->getId()){
					$this->aTmp[$i] = $oFestival;
					break;
				}
			}

			$_SESSION['festival'] = serialize($this->aTmp);
		}

		public function delete(Festival $oFestival){

			for($i = 0; $i < sizeof($this->aTmp); $i++){
				if($this->aTmp[$i]->getId() == $oFestival->getId()){
					array_splice($this->aTmp, $i, 1);
					break;
				}
			}

			$_SESSION['festival'] = serialize($this->aTmp);
		}

		public function getById($iId){

			/* @@var $oFestival \Model\Festival */
			foreach($this->aTmp as $oFestival){
				if($oFestival->getId() == $iId){
					return $oFestival;
				}
			}

			return null;
		}

		public function getByIdToken($sIdToken){

			/* @@var $oFestival \Model\Festival */
			foreach($this->aTmp as $oFestival){
				if($oFestival->getIdToken() == $sIdToken){
					return $oFestival;
				}
			}

			return null;
		}

		public function getAll(){
			return $this->aTmp;
		}

		public function getCount(){
			return sizeof($this->aTmp);
		}
	}