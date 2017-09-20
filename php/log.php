<?php

/*
 * PURPOSE:
 * 		Debug function from http://php.net/manual/en/debugger.php
 */
function debug ()
{
	/*
	 * create formatted debug() string
	*/
	$output = 'DEBUG: ';
	$args = func_get_args ();
	if (!empty ($args))
	{
		ob_start ();
		foreach ($args as $arg)
		{
			var_dump ($arg);
		}/*for each arg()*/
		$output .= ob_get_contents ();
		ob_end_clean ();
	}/*if specified debug string in function args*/

	$backtrace = debug_backtrace();
	$line = htmlspecialchars($backtrace[0]['line']);
	//$file = htmlspecialchars(str_replace(array('\\', $doc_root), array('/', ''), $backtrace[0]['file']));
	$file = $backtrace[0]['file'];
	$class = !empty($backtrace[1]['class']) ? htmlspecialchars($backtrace[1]['class']) . '::' : '';
	$function = !empty($backtrace[1]['function']) ? htmlspecialchars($backtrace[1]['function']) . '() ' : '';

	$output .= ' <<< '.$file.'('.$line.'): '.$class.$function;

	/*
	 * write the debug string to apache's error log
	*/
	error_log ($output);
}/*debug()*/

function log_r_last_error ()
{
	$last_error = error_get_last();
	return 'ERROR('.$last_error['type'].','.$last_error['message'].','.$last_error['file'].','.$last_error['line'].')';
}/*log_r_last_error()*/