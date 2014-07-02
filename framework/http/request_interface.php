<?php
	namespace Framework\Http;

	/* @var \Framework\Http\Request */
	interface RequestInterface{

		public function method();

		public function url();

		public function format();

		public function secure();

		public function ajax();

		public function ip();

		public function wantsJson();
	}