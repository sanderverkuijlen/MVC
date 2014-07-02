<?php
namespace Framework\Exception;

class ApiMethodNotSupportedException extends Exception{

	public function __construct($sMethod){
		parent::__construct('Method '.$sMethod.' is not supported for this resource.');
	}
}