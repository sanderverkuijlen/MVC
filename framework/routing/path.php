<?php
	namespace Framework\Routing;

	class Path extends Routable{

		private $sEnvironmentAlias;
		private $sRegex;
		private $fCallback;
		private $aFilters;

		/**
		 * @param          $sEnvironmentAlias
		 * @param          $sRegex
		 * @param callable $fCallback
		 * @param array    $aFilters
		 */
		public function __construct($sEnvironmentAlias, $sRegex, \Closure $fCallback, array $aFilters = []){

			$this->sEnvironmentAlias    = $sEnvironmentAlias;
			$this->sRegex               = $sRegex;
			$this->fCallback            = $fCallback;
			$this->aFilters             = $aFilters;
		}

		public function resolve($sEnvironmentAlias, $sUrl, array $aUrlParams, array $aPattern){
			$aAppliedPatterns = [];
			$aPatternMatches = [];

			if($this->match($sEnvironmentAlias, $sUrl, $aPattern, $aAppliedPatterns, $aPatternMatches)){

				$this->handle($aAppliedPatterns, $aPatternMatches, $aUrlParams);

				return true;
			}

			return false;
		}

		private function match($sEnvironmentAlias, $sUrl, $aPattern, array &$aAppliedPatterns, array &$aPatternMatches){

			//Check de environment
			if($this->sEnvironmentAlias !== $sEnvironmentAlias){
				return false;
			}

			//Check de regex (inclusief patterns)
			$sPathRegex = $this->preparePatternRegex($this->sRegex, $aPattern, $aAppliedPatterns);

			if(!preg_match('/^'.$sPathRegex.'$/', $sUrl, $aPatternMatches)){
				return false;
			}

			//Check de filters
			foreach($this->aFilters as $sFilterKey){

				if(!\Router::resolveFilter($sFilterKey)){
					return false;
				}
			}

			return true;
		}

		private function handle(array $aAppliedPatterns, array &$aPatternMatches, array $aUrlParams){

			//Houd bij welke parameters er uit de url gehaald zijn
			for($i = 0; $i < sizeof($aAppliedPatterns); $i++){
				$aUrlParams[$aAppliedPatterns[$i]] = $aPatternMatches[$i+1];
			}

			//Roep de callback aan met de gevonden parameters als argument
			call_user_func($this->fCallback, $aUrlParams);
		}
	}