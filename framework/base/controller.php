<?php
namespace Framework\Base;

use Framework\Exception\RouteNotFoundException;

abstract class Controller{

	//Voorkomt fatal errors bij foute routes en gooit in plaats daarvan een exception op
	public function __call($sName, $aArgs){
		throw new RouteNotFoundException(\Request::url(), \Request::method());
	}
}