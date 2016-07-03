<?php
namespace Fgms\Distributor;

/**
 *	An implementation of the \ref WordPress interface
 *	which simply calls builtin WordPress functions.
 */
class WordPressImpl implements WordPress
{
	public function __call ($name, array $args)
	{
		if ($name==='dbDelta') require_once ABSPATH.'wp-admin/includes/upgrade.php';
		return call_user_func_array($name,$args);
	}
}