<?php
	namespace Framework\Templating;

	use Framework\Traits\Singleton;

	class ViewFactory implements ViewFactoryInterface{
		use Singleton;

		public function __construct(){
		}

		public function make($sPath, array $aData = []){

			if($this->exists($sPath)){
				return new View($sPath, $aData);
			}
			else{
				throw new \Exception('Template not found');
			}
		}

		public function exists($sPath){
			return file_exists(VIEW_ROOT.$sPath.'.php');
		}
	}