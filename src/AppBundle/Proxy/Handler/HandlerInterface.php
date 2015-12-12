<?php

namespace AppBundle\Proxy\Handler;

use AppBundle\Entity\ServerInterface;
use RomanPitak\Nginx\Config\Scope;

interface HandlerInterface
{
    /**
     * @return ServerInterface[]
     */
    public function getRecords();

    /**
     * @param ServerInterface $server
     *
     * @return Scope
     */
    public function buildConfig(ServerInterface $server);
}
