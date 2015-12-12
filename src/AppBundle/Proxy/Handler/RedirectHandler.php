<?php

namespace AppBundle\Proxy\Handler;

use AppBundle\Entity\Redirect;
use AppBundle\Entity\ServerInterface;
use RomanPitak\Nginx\Config\Directive;
use RomanPitak\Nginx\Config\Scope;

class RedirectHandler extends AbstractHandler
{
    /**
     * @param Redirect|ServerInterface $server
     *
     * @return Scope
     */
    public function buildConfig(ServerInterface $server)
    {
        return Scope::create()
            ->addDirective(Directive::create('server')
                ->setChildScope(Scope::create()
                    ->addDirective(Directive::create('listen', 80))
                    ->addDirective(Directive::create('server_name', $this->getServerName($server)))
                    ->addDirective(Directive::create('location', '/', Scope::create()
                        ->addDirective(Directive::create('return', '301 '.$server->getTarget()))
                    ))
                )
            );
    }
}
