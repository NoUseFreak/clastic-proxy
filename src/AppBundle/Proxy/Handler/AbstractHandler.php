<?php

namespace AppBundle\Proxy\Handler;

use AppBundle\Entity\Domain;
use AppBundle\Entity\ServerInterface;
use Doctrine\ORM\EntityRepository;

abstract class AbstractHandler implements HandlerInterface
{
    protected $repo;

    public function __construct(EntityRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getRecords()
    {
        return $this->repo->findAll();
    }

    final protected function getServerName(ServerInterface $server)
    {
        return implode(' ', array_map(function (Domain $domain) {
            return $domain->getFqdn();
        }, $server->getDomains()->getValues()));
    }
}
