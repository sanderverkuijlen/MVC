<?php
	try{
		$sIncludePath = '../';

		//Bootstrap (initializatie, autoloading, etc)
		require_once($sIncludePath.'system/config/bootstrap.php');

		//Resolve de request
		Router::resolve();
	}
	catch(Exception $e){
		?>
		<h1>Onverwachte foutmelding</h1>
		<p><?=$e->getMessage()?></p>
		<?
	}
