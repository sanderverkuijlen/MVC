<?php
	namespace Repository;

	use Framework\Base\Repository;
	use Model\Artiest;
	use Model\Festival;

	class ArtiestRepository extends Repository{

		private $aTmp = [];

		public function __construct(){

			if(array_key_exists('artiest', $_SESSION)){
				$this->aTmp = unserialize($_SESSION['artiest']);
			}
			else{
				$_SESSION['artiest'] = serialize($this->aTmp);
			}
		}

		public function insert(Artiest $oArtiest){

			$iNewId = 1;

			/* @@var $oOldArtiest \Model\Artiest */
			foreach($this->aTmp as $oOldArtiest){
				if($oOldArtiest->getId() >= $iNewId){
					$iNewId = $oOldArtiest->getId()+1;
				}
			}

			$oArtiest->setId($iNewId);
			$oArtiest->setIdToken('a'.$iNewId);

			$this->aTmp[] = $oArtiest;

			$_SESSION['artiest'] = serialize($this->aTmp);

			return $oArtiest;
		}

		public function update(Artiest $oArtiest){

			for($i = 0; $i < sizeof($this->aTmp); $i++){
				if($this->aTmp[$i]->getId() == $oArtiest->getId()){
					$this->aTmp[$i] = $oArtiest;
					break;
				}
			}

			$_SESSION['artiest'] = serialize($this->aTmp);
		}

		public function delete(Artiest $oArtiest){

			for($i = 0; $i < sizeof($this->aTmp); $i++){
				if($this->aTmp[$i]->getId() == $oArtiest->getId()){
					array_splice($this->aTmp, $i, 1);
					break;
				}
			}

			$_SESSION['artiest'] = serialize($this->aTmp);
		}

		public function getById($iId){

			/* @@var $oArtiest \Model\Artiest */
			foreach($this->aTmp as $oArtiest){
				if($oArtiest->getId() == $iId){
					return $oArtiest;
				}
			}

			return null;
		}

		public function getByIdToken($sIdToken){

			/* @@var $oArtiest \Model\Artiest */
			foreach($this->aTmp as $oArtiest){
				if($oArtiest->getIdToken() == $sIdToken){
					return $oArtiest;
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

		public function getByFestival(Festival $oFestival){
			$aResult = [];

			/* @var $oArtiest \Model\Artiest */
			foreach($this->aTmp as $oArtiest){

				if($oArtiest->getFestivalId() == $oFestival->getId()){
					$aResult[] = $oArtiest;
				}
			}

			return $aResult;
		}
	}