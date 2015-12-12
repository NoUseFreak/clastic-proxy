<?php

namespace AppBundle\Proxy\Handler;

use AppBundle\Entity\Proxy;
use AppBundle\Entity\ServerInterface;
use RomanPitak\Nginx\Config\Directive;
use RomanPitak\Nginx\Config\Scope;

class ProxyHandler extends AbstractHandler
{
    /**
     * @param Proxy|ServerInterface $server
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
                        ->addDirective(Directive::create('proxy_pass', 'http://'.$server->getBackend().':'.$server->getPort()))
                        ->addDirective(Directive::create('proxy_set_header', 'Host $host'))
                        ->addDirective(Directive::create('proxy_set_header', 'X-Real-IP $remote_addr'))
                        ->addDirective(Directive::create('proxy_set_header', 'X-Forwarded-For $proxy_add_x_forwarded_for'))
                    ))
                )
            );
    }
}
