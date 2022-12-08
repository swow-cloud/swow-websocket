<?php

declare(strict_types=1);
/**
 * This file is part of Swow-Chat.
 *
 * @link     https://xxx.com
 * @document https://xxx.wiki
 * @license  https://github.com/swow-cloud/swow-websocket/master/LICENSE
 */
namespace Hyperf\Di\Resolver;

use Hyperf\Di\Definition\DefinitionInterface;
use Hyperf\Di\Definition\FactoryDefinition;
use Hyperf\Di\Definition\ObjectDefinition;
use Hyperf\Di\Definition\SelfResolvingDefinitionInterface;
use Hyperf\Di\Exception\InvalidDefinitionException;
use Psr\Container\ContainerInterface;

class ResolverDispatcher implements ResolverInterface
{
    protected ?ObjectResolver $objectResolver = null;

    protected ?FactoryResolver $factoryResolver = null;

    public function __construct(private ContainerInterface $container)
    {
    }

    /**
     * Resolve a definition to a value.
     *
     * @param DefinitionInterface $definition object that defines how the value should be obtained
     * @param array $parameters optional parameters to use to build the entry
     * @return mixed value obtained from the definition
     * @throws InvalidDefinitionException if the definition cannot be resolved
     */
    public function resolve(DefinitionInterface $definition, array $parameters = [])
    {
        if ($definition instanceof SelfResolvingDefinitionInterface) {
            return $definition->resolve($this->container);
        }

        $resolver = $this->getDefinitionResolver($definition);
        return $resolver->resolve($definition, $parameters);
    }

    /**
     * Check if a definition can be resolved.
     *
     * @param DefinitionInterface $definition object that defines how the value should be obtained
     * @param array $parameters optional parameters to use to build the entry
     */
    public function isResolvable(DefinitionInterface $definition, array $parameters = []): bool
    {
        if ($definition instanceof SelfResolvingDefinitionInterface) {
            return $definition->isResolvable($this->container);
        }

        $resolver = $this->getDefinitionResolver($definition);
        return $resolver->isResolvable($definition, $parameters);
    }

    /**
     * Returns a resolver capable of handling the given definition.
     *
     * @throws \RuntimeException no definition resolver was found for this type of definition
     */
    private function getDefinitionResolver(DefinitionInterface $definition): ResolverInterface
    {
        switch (true) {
            case $definition instanceof ObjectDefinition:
                if (! $this->objectResolver) {
                    $this->objectResolver = new ObjectResolver($this->container, $this);
                }
                return $this->objectResolver;
            case $definition instanceof FactoryDefinition:
                if (! $this->factoryResolver) {
                    $this->factoryResolver = new FactoryResolver($this->container, $this);
                }
                return $this->factoryResolver;
            default:
                throw new \RuntimeException('No definition resolver was configured for definition of type ' . get_class($definition));
        }
    }
}
