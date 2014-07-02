<?php
	namespace Framework\Exception;

	class ClassNotFoundException extends Exception{

	public function __construct($sClassName){
		parent::__construct('No definition could be found for "'.$sClassName.'".');
	}
}