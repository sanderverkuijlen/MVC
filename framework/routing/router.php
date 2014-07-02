<?php
	namespace Framework\Routing;

	use Framework\Exception\RouteNotFoundException;
	use Framework\Traits\Singleton;

	class Router implements RouterInterface{
		use Singleton;
		private $aFilter            = [];

		private $aEnvironment       = [];

		private $aPath              = [];
		private $aController        = [];

		private $aPattern           = [];


		public function __construct(){
		}

		public function pattern($sTag, $sRegex){
			$this->aPattern[$sTag] = $sRegex;
		}

		public function filter($sKey, \Closure $fFunc){

			$this->aFilter[$sKey] = $fFunc;
		}

		public function environment($sAlias, $sRegex, array $aFilters = []){

			$this->aEnvironment[] = new Environment($sAlias, $sRegex, $aFilters);
		}

		public function path($sEnvironmentAlias, $sRegex, \Closure $fFunc, array $aFilters = []){

			$this->aPath[] = new Path($sEnvironmentAlias, $sRegex, $fFunc, $aFilters);
		}

		public function controller($sEnvironmentAlias, $sRegex, $sController, $aFilters = [], $aSettings = []){

			$this->aController[] = new Controller($sEnvironmentAlias, $sRegex, $sController, $aFilters, $aSettings);
		}

		public function resolve(){

			//We gaan proberen te routen op basis van $sUrl en $sMethod
			$sUrl = \Request::url();
			$sMethod = \Request::method();

			$aUrlParams = [];

			//Bepaal de environment
			/* @var $oEnvironment Environment */
			foreach($this->aEnvironment as $oEnvironment){

				$sEnvUrl = $sUrl;

				//Check of de environment matched met de url, zo ja: dan wordt het gematchte stuk uit $sUrl gestript en worden eventuele gevonden parameters toegevoegd aan $aUrlParams
				if($oEnvironment->resolve($sEnvUrl, $aUrlParams, $this->aPattern)){

					$sEnv = $oEnvironment->getAlias();

					//Check paths
					/* @var $oPath \Framework\Routing\Path */
					foreach($this->aPath as $oPath){

						if($oPath->resolve($sEnv, $sEnvUrl, $aUrlParams, $this->aPattern)){
							//We hebben de route gematched aan een path dus zijn we klaar
							return;
						}
					}

					/* @var $oController \Framework\Routing\Controller */
					foreach($this->aController as $oController){

						if($oController->resolve($sEnv, $sEnvUrl, $sMethod, $aUrlParams, $this->aPattern)){
							//We hebben de route gematched aan een controller dus zijn we klaar
							return;
						}
					}
				}
			}

			//Als we hier aankomen konden we de url niet matchen aan een route
			throw new RouteNotFoundException(\Request::url(), $sMethod);
		}

		public function resolveFilter($sFilterKey){

			$bReverse = false;

			if(preg_match('/^!/', $sFilterKey)){
				$bReverse = true;
				$sFilterKey = substr($sFilterKey, 1);
			}

			$bResult = $this->aFilter[$sFilterKey]();

			return ($bReverse ? !$bResult : $bResult);
		}
	}