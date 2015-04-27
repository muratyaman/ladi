<?php

require __DIR__ . '/../LadyDi/Autoloader.php';
\LadyDi\Autoloader::register();


function main()
{
	$dependencies = [
		'iA' => 'A',
		'iB' => 'B',
		'iC' => 'C',
	];

	$factory = new \LadyDi\Factory();
	$factory->setDependencies($dependencies);

	$a = $factory->get('iA');
	$b = $factory->get('iB');
	$c = $factory->get('iC');

	$a->doA();
	$b->doB();
	$c->doC();
}

// implementation details: interfaces and classes

interface iA
{
	function doA();
}
interface iB
{
	function doB();
}
interface iC
{
	function doC();
}

class A implements iA, \LadyDi\DependencyConsumer
{
	/**
	 * var iB
	 */
	private $b;

	function consumeDependencies(\LadyDi\Factory $factory)
	{
		$this->b = $factory->get('iB');
	}

	function doA()
	{
		echo(__METHOD__ . PHP_EOL);
	}

}

class B implements iB, \LadyDi\DependencyConsumer
{
	/**
	 * var iC
	 */
	private $c;

	function consumeDependencies(\LadyDi\Factory $factory)
	{
		$this->c = $factory->get('iC');
	}

	function doB()
	{
		echo(__METHOD__ . PHP_EOL);
	}

}

class C implements iC, \LadyDi\DependencyConsumer
{
	/**
	 * var iA
	 */
	private $a;

	function consumeDependencies(\LadyDi\Factory $factory)
	{
		$this->a = $factory->get('iA');
	}

	function doC()
	{
		echo(__METHOD__ . PHP_EOL);
	}
}

//run example
main();

