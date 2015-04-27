<?php
namespace LadyDi;

/**
 * Simple factory class to contruct objects based on dependencies
 */
class Factory
{

    /**
     * Array of interface names and class names so that we know which interface is implemented by which class
     * @var array
     */
    protected $dependencies = [];

    /**
     * Array of objects
     * @var array
     */
    protected $objects = [];

    /**
     * @param array $dependencies
     */
    public function setDependencies(array $dependencies)
    {
        $this->dependencies = $dependencies;
    }

    /**
     * @param string $interface
     */
    protected function getClassName($interface)
    {
        if (! isset($this->dependencies[$interface])) {
            throw new FactoryException('Unknown interface ' . $interface);
        }
        $className = $this->dependencies[$interface];
        if (! is_string($className)) {
            throw new FactoryException('Invalid class name for ' . $interface);
        }

        if (! class_exists($className, $autoload = true)) {
            throw new FactoryException('Unknown class ' . $className);
        }

        return $className;
    }

    public function get($interface)
    {
        if (! isset($this->objects[$interface])) {

            $className = $this->getClassName($interface);

            try {
                // Constructor has no inputs
                $object = new $className();
            } catch (\Exception $ex) {
                throw new FactoryException('Unable to create object of class ' . $className);
            }

            if (! ($object instanceof $interface)) {
            	throw new FactoryException('Object of class ' . $className . ' does not implement ' . $interface);
            }

            // The solution for circular requirements
            $this->objects[$interface] = $object;

            if (! ($object instanceof DependencyConsumer)) {
                throw new FactoryException('Object of class ' . $className . ' does not implement LadyDi\DependencyInformer');
            }

            // Let object use factory to retrieve the objects it depends on
            $object->consumeDependencies($this);
        }

        return $this->objects[$interface];
    }



}