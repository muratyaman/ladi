<?php
namespace LadyDi;

interface DependencyConsumer
{
	/**
	 * Consume dependencies from factory
	 * @param Factory $factory
	 * @return void
	 */
	function consumeDependencies(Factory $factory);
	
}