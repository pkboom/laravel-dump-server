<?php

namespace Pkboom\DumpServer;

use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\ContextProvider\ContextProviderInterface;

/**
 * @see: https://github.com/beyondcode/laravel-dump-server/blob/master/src/RequestContextProvider.php
 */
class RequestContextProvider implements ContextProviderInterface
{
    private $currentRequest;

    private $cloner;

    private $time;

    public function __construct(Request $currentRequest = null)
    {
        $this->currentRequest = $currentRequest;
        $this->cloner = new VarCloner();
        $this->cloner->setMaxItems(0);

        $this->time = time();
    }

    public function getContext(): ?array
    {
        if ($this->currentRequest === null) {
            return null;
        }

        $controller = null;

        if ($route = $this->currentRequest->route()) {
            $controller = $route->controller;

            if (!$controller && !is_string($route->action['uses'])) {
                $controller = $route->action['uses'];
            }
        }

        return [
            'uri' => $this->currentRequest->getUri(),
            'method' => $this->currentRequest->getMethod(),
            'controller' => $controller ? $this->cloner->cloneVar(class_basename($controller)) : $this->cloner->cloneVar(null),
            'identifier' => $this->time,
        ];
    }
}
