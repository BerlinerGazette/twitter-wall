<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDirectories()
	{
		$directories = array(
			'data/db' => APPLICATION_DATA . '/db',
			'data/twitter' => APPLICATION_DATA . '/twitter'
		);

		foreach ($directories as $dir) {
			if (is_file($dir)) {
				throw new App_Exception('File (' . $dir . ') exists but has to be a directory!');
			}

			if (is_link($dir)) {
				throw new App_Exception('Link (' . $dir . ') exists but has to be a directory!');
			}

			if (is_dir($dir)) {
				continue;
			}

			if (false === mkdir($dir, 0750, true)) {
				throw new Exception('Failed to create directory (' . $dir . ')!');	
			}
		}
	}
}
