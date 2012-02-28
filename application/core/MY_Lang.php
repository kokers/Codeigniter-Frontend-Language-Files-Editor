<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Lang extends CI_Lang {

	/**
    * Fetch a single line of text from the language array
    * Un-quotes a quoted string if it's not .
	 *
	 * @access	public
	 * @param	string	$line	the language line
	 * @return	string   Un-quotes a quoted string if it's not an array.
	 */
	function line($line = '')
	{
		$value = ($line == '' OR ! isset($this->language[$line])) ? FALSE : $this->language[$line];

		// Because killer robots like unicorns!
		if ($value === FALSE)
		{
			log_message('error', 'Could not find the language line "'.$line.'"');
		}

		return is_array($value) ? $value : stripslashes($value);
	}

}

/* End of file MY_Lang.php */
/* Location: ./application/core/MY_Lang.php */
