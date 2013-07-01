<?php

namespace Bernard\Spork;

use Bernard\Message\Envelope;
use Bernard\ServiceResolver;
use Spork\ProcessManager;

/**
 * Decorates an ordinary ServiceResolver and will return ForkingInvocator
 * for the resolve method.
 *
 * @see ForkingInvocator
 * @package Bernard
 */
class ProcessDecoratingResolver implements \Bernard\ServiceResolver
{
    protected $spork;
    protected $resolver;

    /**
     * @param ProcessManager $manager
     * @param Invocator      $invocator
     */
    public function __construct(ProcessManager $manager, ServiceResolver $resolver)
    {
        $this->spork = $manager;
        $this->resolver = $resolver;
    }

    /**
     * {@inheritDoc}
     */
    public function register($name, $service)
    {
        $this->resolver->register($name, $service);
    }

    /**
     * {@inheritDoc}
     */
    public function resolve(Envelope $envelope)
    {
        return new ProcessInvocator($this->spork, $this->resolver->resolve($envelope));
    }
}
