<?php


namespace App\Simplex;

// ...


use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

class Framework
{
    protected $matcher;
    protected $controllerResolver;
    protected $argumentResolver;

    public function __construct(UrlMatcherInterface $matcher, ControllerResolverInterface $resolver, ArgumentResolverInterface $argumentResolver)
    {
        $this->matcher = $matcher;
        $this->controllerResolver = $resolver;
        $this->argumentResolver = $argumentResolver;
    }

    // ...
}