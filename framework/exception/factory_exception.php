<?php
	namespace Framework\Exception;

	class FactoryException extends Exception{

	public function __construct($sMessage){
		parent::__construct($sMessage);
	}
}