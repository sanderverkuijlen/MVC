<?php
	namespace Framework\Routing;

	class Controller extends Routable{

		const CONTROLLER_ROUTE  = '(/id_token)(/action)';
		const RELATIE_ROUTE     = '(controller)/(id_token)/';

		private $sEnvironmentAlias;
		private $sRegex;
		private $sController;
		private $aFilters;
		private $aSettings;

		/**
		 * @param          $sEnvironmentAlias
		 * @param          $sRegex
		 * @param          $sController
		 * @param array    $aFilters
		 * @param array    $aSettings
		 */
		public function __construct($sEnvironmentAlias, $sRegex, $sController, array $aFilters = [], array $aSettings = []){

			$this->sEnvironmentAlias    = $sEnvironmentAlias;
			$this->sRegex               = $sRegex;
			$this->sController          = $sController;
			$this->aFilters             = $aFilters;
			$this->aSettings            = $aSettings;
		}

		public function resolve($sEnvironmentAlias, $sUrl, $sMethod, array $aUrlParams, array $aPattern){
			$aAppliedPatterns = [];
			$aPatternMatches = [];

			if($this->match($sEnvironmentAlias, $sUrl, $aPattern, $aAppliedPatterns, $aPatternMatches)){

				$this->handle($sMethod, $aAppliedPatterns, $aPatternMatches, $aUrlParams);

				return true;
			}

			return false;
		}

		private function match($sEnvironmentAlias, $sUrl, $aPattern, array &$aAppliedPatterns, array &$aPatternMatches){
			$aRelatieAppliedPatterns = [];
			$aRelatiePatternMatches = [];

			//Check de environment
			if($this->sEnvironmentAlias !== $sEnvironmentAlias){
				return false;
			}

			//Check de controller-regex (inclusief patterns)
			$sControllerRegex = $this->preparePatternRegex($this->sRegex.self::CONTROLLER_ROUTE, $aPattern, $aAppliedPatterns);
			if(!preg_match('/'.$sControllerRegex.'$/', $sUrl, $aPatternMatches)){
				return false;
			}

			//Haal het controller stuk uit de url zodat we het relatie-stuk overhouden
			$sRelatieUrl = substr($sUrl, 0, -strlen($aPatternMatches[0]));
			$sRelatieUrl = $this->cleanUrl($sRelatieUrl);

			if($sRelatieUrl != ''){
				$sRelatieUrl .= '/';

				//Check de relatie-regex (inclusief patterns)
				$sRelatieRegex = $this->preparePatternRegex(self::RELATIE_ROUTE, $aPattern, $aRelatieAppliedPatterns);
				if(!preg_match('/^(?:'.$sRelatieRegex.'\/)*$/', $sRelatieUrl)){
					return false;
				}

				//Verwerk de eventuele parameters uit de relatie-url
				preg_match_all('/'.$sRelatieRegex.'/', $sRelatieUrl, $aRelatiePatternMatches);

				//Zet de gevonden relaties in $aUrlParams
				$iRelatiePatternOffset = sizeof($aAppliedPatterns);
				for($i = 0; $i < sizeof($aRelatiePatternMatches[0]); $i++){

					//Key
					$aAppliedPatterns[$iRelatiePatternOffset+$i] = $aRelatiePatternMatches[1][$i].'_'.$aRelatieAppliedPatterns[1];

					//Value
					$aPatternMatches[$iRelatiePatternOffset+$i+1] = $aRelatiePatternMatches[2][$i];
				}
			}

			//Check de filters
			foreach($this->aFilters as $sFilterKey){

				if(!\Router::resolveFilter($sFilterKey)){
					return false;
				}
			}

			return true;
		}

		private function handle($sMethod, array $aAppliedPatterns, array &$aPatternMatches, array $aUrlParams){

			//Houd bij welke parameters er uit de route gehaald zijn
			for($i = 0; $i < sizeof($aAppliedPatterns); $i++){

				if($aPatternMatches[$i+1] !== ''){
					$aUrlParams[$aAppliedPatterns[$i]] = $aPatternMatches[$i+1];
				}
			}

			//Maak een instantie van de geregistreerde controller
			$oController = \Factory::make($this->sController);

			//Bepaal welke functie we aan moeten roepen op de controller
			$sFunctie = strtolower($sMethod);

			//Index, Add en Detail zijn acties met een afwijkend patroon
			if($aUrlParams['id_token'] == '' && $aUrlParams['action'] == ''){
				$sFunctie .= 'Index';
			}
			elseif($aUrlParams['id_token'] == '' && $aUrlParams['action'] == 'add'){
				$sFunctie .= 'Add';
			}
			elseif($aUrlParams['id_token'] != '' && $aUrlParams['action'] == ''){
				$sFunctie .= 'Detail';
			}
			//Alle andere acties volgen een vast patroon
			elseif($aUrlParams['action'] != ''){
				//TODO: Utils class maken met CamelCase functie
				$sFunctie .= ucfirst($aUrlParams['action']);
			}

			//Call de functie van de controller
			call_user_func_array(array($oController, $sFunctie), array($aUrlParams));
		}
	}