<?php
	namespace Framework\Http;

	/* @var \Framework\Http\Response */
	interface ResponseInterface{

		static public function redirect();

		static public function routeRedirect();

		static public function errorRedirect();
	}