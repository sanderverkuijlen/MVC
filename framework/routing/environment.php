<?php
	namespace Framework\Routing;

	class Environment extends Routable{

		private $sAlias;
		private $sRegex;
		private $aFilters;

		public function __construct($sAlias, $sRegex, $aFilters){

			$this->sAlias       = $sAlias;
			$this->sRegex       = $sRegex;
			$this->aFilters     = $aFilters;
		}

		public function resolve(&$sUrl, array &$aUrlParams, array $aPattern){
			$aAppliedPatterns = [];
			$aPatternMatches = [];

			//Clean de url
			$sUrl = $this->cleanUrl($sUrl);

			if($this->match($sUrl, $aPattern, $aAppliedPatterns, $aPatternMatches)){

				$this->handle($sUrl, $aAppliedPatterns, $aPatternMatches, $aUrlParams);

				return true;
			}

			return false;
		}

		private function match($sUrl, array $aPattern, array &$aAppliedPatterns, array &$aPatternMatches){

			//Check regex (inclusief patterns)
			$sEnvRegex = $this->preparePatternRegex($this->sRegex, $aPattern, $aAppliedPatterns);
			if($sEnvRegex != '' && !preg_match('/^'.$sEnvRegex.'(?:\/|$)/', $sUrl, $aPatternMatches)){
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

		private function handle(&$sUrl, array $aAppliedPatterns, array $aPatternMatches, array &$aUrlParams){

			//Strip het gematchte stuk van de url van het begin af, de rest van de matching doen we op wat er na de environment staat
			$sUrl = substr($sUrl, strlen($aPatternMatches[0]));

			//Clean de nieuwe url
			$sUrl = $this->cleanUrl($sUrl);

			//Log eventuele parameters die verwerkt waren in de environment url
			for($i = 0; $i < sizeof($aAppliedPatterns); $i++){
				$aUrlParams[$aAppliedPatterns[$i]] = $aPatternMatches[$i+1];
			}
		}


		public function getAlias(){
			return $this->sAlias;
		}
	}