<?php
namespace Fgms\Distributor;

class ControllerImpl extends Controller
{
	public function output($str)
	{
		echo($str);
	}
	
	public function header($header)
	{
		header($header);
	}

	private function superglobal ($key, $default, $get)
	{
		$super=$get ? $_GET : $_POST;
		if (!isset($super[$key])) return $default;
		$v=$super[$key];
		$v=preg_replace('/^\\s+|\\s+$/u','',$v);
		if ($v==='') return $default;
		return $v;
	}

	public function get($key, $default=null)
	{
		return $this->superglobal($key,$default,true);
	}

	public function post($key, $default=null)
	{
		return $this->superglobal($key,$default,false);
	}
}