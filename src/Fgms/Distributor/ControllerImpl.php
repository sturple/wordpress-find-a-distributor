<?php
namespace Fgms\Distributor;

class ControllerImpl extends Controller
{
	protected function output($str)
	{
		echo($str);
	}
	
	protected function header($header)
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

	protected function get($key, $default=null)
	{
		return $this->superglobal($key,$default,true);
	}

	protected function post($key, $default=null)
	{
		return $this->superglobal($key,$default,false);
	}
}