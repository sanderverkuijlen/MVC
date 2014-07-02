<?php
namespace Framework\Base;

use Framework\Exception\ApiMethodNotSupportedException;

abstract class ApiController extends Controller{

	public function get(){
		throw new ApiMethodNotSupportedException('GET');
	}
	public function post(){
		throw new ApiMethodNotSupportedException('POST');
	}
	public function put(){
		throw new ApiMethodNotSupportedException('PUT');
	}
	public function patch(){
		throw new ApiMethodNotSupportedException('PATCH');
	}
	public function delete(){
		throw new ApiMethodNotSupportedException('DELETE');
	}
}