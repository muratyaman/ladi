<?php
namespace LadyDi;

/**
 * Simple factory class to contruct objects based on dependencies
 */
class Autoloader
{
	static function register()
	{
		spl_autoload_register(
			function($className){
				if (substr($className, 0, 6) == 'LadyDi') {
					$className = substr($className, 6);//cut off LadyDi
					require __DIR__ . '/' . $className . '.php';
				}
			},
			true
		);
	}
}