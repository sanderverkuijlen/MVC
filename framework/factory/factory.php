<?php
	namespace Framework\Factory;

	use Framework\Exception\FactoryException;
	use Framework\Exception\ClassNotFoundException;

	class Factory{

		//Aliassen, bijvoorbeeld: "router" -> "\Framework\Http\RouterInterface"
		private $aAlias     = [];

		//Bindings, bijvoorbeeld: "Framework\Http\RequestInterface" -> "Framework\Http\Request"
		private $aBinding   = [];

		//Geïnstantieerde objecten of closures die een geïnstantieerd object retourneren
		private $aObject    = [];

		//Mockeries (voor unit-tests)
		private $aMock      = [];


		public function make($sClass, array $aArgs = []){
			$sOriginalClass = $sClass;

			$sClass = $this->normalizeClassName($sClass);

			//Rewrite $sClass als het een alias is
			if(array_key_exists($sClass, $this->aAlias)){
				$sClass = $this->aAlias[$sClass];
			}

			//Rewrite $sClass als deze gebonden is aan een andere klasse
			if(array_key_exists($sClass, $this->aBinding)){
				$sClass = $this->aBinding[$sClass];
			}

			//Check of er een mockery beschikbaar is voor $sClass
			if(array_key_exists($sClass, $this->aMock)){

				//Als het gevonden object een closure is dan voeren we deze uit, we verwachten dan een object als return uit de closure
				if($this->aMock[$sClass] instanceof \Closure){
					$oResolvedObject = $this->buildFromClosure($this->aMock[$sClass], $sClass);
				}
				//Het is geen closure? dan gaan we er vanuit dat de value een pre-resolved object is
				else{
					$oResolvedObject = $this->aMock[$sClass];
				}
			}
			//Check dan of er een voorgedefinieërd object of closure is
			elseif(array_key_exists($sClass, $this->aObject)){

				//Als het gevonden object een closure is dan voeren we deze uit, we verwachten dan een object als return uit de closure
				if($this->aObject[$sClass] instanceof \Closure){
					$oResolvedObject = $this->buildFromClosure($this->aObject[$sClass], $sClass);
				}
				//Het is geen closure? dan gaan we er vanuit dat de value een pre-resolved object is
				else{
					$oResolvedObject = $this->aObject[$sClass];
				}
			}
			//Maak een nieuwe instantie aan
			else{
				//Wordt er gevraagt om deze IoC container? return dan dit object ipv een kopie te maken
				if($sClass == get_called_class()){
					$oResolvedObject = $this;
				}
				//Voor alle andere klassen gaan we proberen om deze aan te maken
				else{
					//Maak een nieuwe instantie aan van $sClass
					$oResolvedObject = $this->buildFromClass($sClass, $aArgs);

					//Is dit object een singleton? registreer deze dan zodat die niet constant opnieuw wordt aangemaakt
					if($oResolvedObject && $this->isSingleton($oResolvedObject)){
						$this->register($sClass, $oResolvedObject);
					}
				}
			}

			if($oResolvedObject === null){
				throw new FactoryException('Factory could not resolve "'.$sOriginalClass.'" ('."$sClass".').');
			}
			elseif(!is_object($oResolvedObject)){
				throw new FactoryException('Factory found a non-object while resolving "'.$sOriginalClass.'" ('."$sClass".').');
			}
			elseif(!$oResolvedObject instanceof $sClass){
				throw new FactoryException('Factory found an incompatible type while resolving "'.$sOriginalClass.'" ('."$sClass".'), it found "'.get_class($oResolvedObject).'".');
			}

			return $oResolvedObject;
		}

		/* Sander: Misschien dat dit handig zou zijn, maar ik ben er niet van overtuigd dat het een nette manier van werken is. */
//		public function call($mObject, $sFunc, array $aArgs = []){
//
//			//$mObject kan een object zijn, maar kan ook een klasse-naam (string) zijn. In dat geval gaan we hier eerst een object bij ophalen
//			if(!is_object($mObject)){
//				$mObject = $this->make($mObject);
//			}
//
//			if(is_object($mObject)){
//				$oRefMethod = new \ReflectionMethod(get_class($mObject), $sFunc);
//
//				if($oRefMethod){
//					$aRefParams = $oRefMethod->getParameters();
//
//					$aArgs = $this->buildArgumentArray($aRefParams, $aArgs);
//
//					return $oRefMethod->invokeArgs($mObject, $aArgs);
//				}
//			}
//
//			throw new \Exception('Functie "'.$sFunc.'" kan niet aangeroepen worden op object van type "'.get_class($mObject).'"');
//		}

		public function alias($sAlias, $sClass){

			$sAlias = $this->normalizeClassName($sAlias);
			$sClass = $this->normalizeClassName($sClass);

			$this->aAlias[$sAlias] = $sClass;
		}
		public function unalias($sAlias){

			$sAlias = $this->normalizeClassName($sAlias);

			unset($this->aAlias[$sAlias]);
		}

		public function bind($sBind, $sClass){

			$sBind = $this->normalizeClassName($sBind);
			$sClass = $this->normalizeClassName($sClass);

			$this->aBinding[$sBind] = $sClass;
		}
		public function unbind($sBind){

			$sBind = $this->normalizeClassName($sBind);

			unset($this->aBinding[$sBind]);
		}

		public function register($sClass, $mMixed){

			$sClass = $this->normalizeClassName($sClass);

			$this->aObject[$sClass] = $mMixed;
		}
		public function unregister($sClass){

			$sClass = $this->normalizeClassName($sClass);

			unset($this->aObject[$sClass]);
		}

		public function mock($sClass, $mMixed){

			$sClass = $this->normalizeClassName($sClass);

			$this->aMock[$sClass] = $mMixed;
		}
		public function unmock($sClass){

			$sClass = $this->normalizeClassName($sClass);

			unset($this->aMock[$sClass]);
		}


		private function buildFromClass($sClass, array $aSuppliedArgs = []){

			$oObject = null;

			$oRefClass = new \ReflectionClass($sClass);
			if($oRefClass){
				$aArgs = [];
				$oRefConstructor = $oRefClass->getConstructor();

				if($oRefConstructor){
					$aRefParams = $oRefConstructor->getParameters();

					$aArgs = $this->buildArgumentArray($sClass, $aRefParams, $aSuppliedArgs);
				}

				//Klasse maken
				$oNewRefClass = new \ReflectionClass($sClass);
				$oObject = $oNewRefClass->newInstanceArgs($aArgs);
			}

			if($oObject == null){
				throw new ClassNotFoundException('Klasse "'.$sClass.'" kon niet gemaakt worden.');
			}

			return $oObject;
		}
		private function buildFromClosure($fClosure, $sClass = ''){
			$oObject = null;

			$oRefClosure = new \ReflectionFunction($fClosure);
			if($oRefClosure){
				$aRefParams = $oRefClosure->getParameters();

				$aArgs = $this->buildArgumentArray($sClass, $aRefParams);

				$oObject = $oRefClosure->invokeArgs($aArgs);
			}
			if($oObject == null){
				throw new ClassNotFoundException('Klasse "'.$sClass.'" kon niet gemaakt worden.');
			}

			return $oObject;
		}
		private function buildArgumentArray($sClass, array $aRefParams, array $aSuppliedArgs = []){

			$aArgs = [];

			/* @var $oRefParam \ReflectionParameter */
			foreach($aRefParams as $oRefParam){
				//Eerst kijken we naar meegestuurde variabelen
				if(array_key_exists($oRefParam->getName(), $aSuppliedArgs)){
					$aArgs[] = $aSuppliedArgs[$oRefParam->getName()];
					continue;
				}
				//Variabele is niet meegestuurd, probeer deze in te vullen
				else{
					//Heeft de parameter een type-hint naar een klasse? probeer deze dan via deze factory te resolven
					$oRefClass = $oRefParam->getClass();
					if($oRefClass){
						$aArgs[] = $this->make($oRefClass->getName());
						continue;
					}

					//Is de parameter optioneel? Vul dan de default waarde in
					if($oRefParam->isOptional() && $oRefParam->isDefaultValueAvailable()){
						$aArgs[] = $oRefParam->getDefaultValue();
						continue;
					}
				}

				//Een van de variabelen kon niet ingevuld worden, als we door zouden gaan geeft dit een fatal error dus gooi een FactoryException zodat het netjes afgehandeld kan worden
				throw new FactoryException('Factory could not resolve all arguments for the construction of "'.$sClass.'".');
			}

			return $aArgs;
		}

		private function normalizeClassName($sClass){

			$sClass = trim($sClass, '\\');
			return $sClass;
		}

		private function isSingleton($sClass){
			$oRefClass = new \ReflectionClass($sClass);
			return in_array('Framework\Traits\Singleton', $oRefClass->getTraitNames());
		}
	}