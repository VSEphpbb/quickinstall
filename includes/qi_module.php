<?php
/**
*
* @package quickinstall
* @copyright (c) 2007 phpBB Limited
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* Module handler from wiedler.ch, optimized for phpbb
* @package quickinstall
*/

class qi_module
{
	protected $modules_path;
	protected $modules_prefix;

	public function __construct($modules_path, $modules_prefix = '')
	{
		$this->modules_path = (string) $modules_path;
		$this->modules_prefix = (string) $modules_prefix;
	}

	public function load($module, $default)
	{
		global $phpEx;

		// just some security (thanks lordlebrand)
		$module = basename($module);

		if (!file_exists($this->modules_path . $this->modules_prefix . $module . '.' . $phpEx))
		{
			$module = $default;
		}

		if (false === @include($this->modules_path . $this->modules_prefix . $module . '.' . $phpEx))
		{
			trigger_error(qi::lang('NO_MODULE', $module), E_USER_ERROR);
		}

		$class_name = $this->modules_prefix . $module;
		$module = new $class_name();
		return $module->run();
	}
}
