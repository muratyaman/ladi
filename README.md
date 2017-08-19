# LaDI

LaDI (Dependency Injection) is a simple and efficient object factory and container

A classic example for circular references: a depends on b, b depends on c, c depends on a

	$dependencies = [// interface-name => class-name
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

