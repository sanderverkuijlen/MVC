<?php
namespace Framework\Exception;

class RouteNotFoundException extends \Exception{

	public function __construct($sUrl, $sMethod){
		parent::__construct('Could not find a route for request "'.$sUrl.'" ('.$sMethod.').');
	}
}