<?php
	namespace Framework\Templating;

	class View implements ViewInterface{

		private $sPath;
		private $aData;

		public function __construct($sPath, $aData){
			$this->sPath = $sPath;
			$this->aData = $aData;
		}

		public function with($sKey, $mValue){
			$this->aData[$sKey] = $mValue;

			return $this;
		}

		public function nest($sAlias, $sPath, $aData){

			$oPartial = \View::make($sPath, $aData);
//			$oPartial = null;

			$this->with($sAlias, $oPartial);

			return $oPartial;
		}

		public function render(){

			ob_start();

			//Extract de parameters die beschikbaar gemaakt zijn voor de template
			extract($this->aData);

			//Include de template
			require(VIEW_ROOT.$this->sPath.'.php');

			return trim(ob_get_clean());
		}

		/**
		 * Get the string contents of the view.
		 *
		 * @return string
		 */
		public function __toString()
		{
			return $this->render();
		}
	}