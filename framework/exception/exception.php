<?php
namespace Framework\Exception;

class Exception extends \Exception{

	public function __construct($sMessage){
		$this->message = '['.get_called_class().']: '.$sMessage;
	}
}