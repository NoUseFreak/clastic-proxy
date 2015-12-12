<?php
/**
 * Created by PhpStorm.
 * User: ddepeuter
 * Date: 12/12/15
 * Time: 00:35
 */

namespace AppBundle\Proxy;


use AppBundle\Entity\Domain;
use AppBundle\Entity\Proxy;
use AppBundle\Entity\ProxyRepository;
use Psr\Log\LoggerInterface;
use RomanPitak\Nginx\Config\Directive;
use RomanPitak\Nginx\Config\Scope;

class Generator
{
    private $proxyRepository;

    public function __construct(ProxyRepository $proxyRepository)
    {
        $this->proxyRepository = $proxyRepository;
    }

    /**
     * @param LoggerInterface $logger
     * @param null $outputDir
     */
    public function generate(LoggerInterface $logger, $outputDir = null)
    {
        $logger->notice('Generate started');

        if (!is_null($outputDir)) {
            $logger->notice('Cleaning dir.');
            $outputDir = realpath($outputDir).'/';

            foreach(glob($outputDir.'*') as $file) {
                unlink($file);
            }
        }

        /** @var Proxy $proxy */
        foreach ($this->proxyRepository->findAll() as $proxy) {
            $config = $this->buildProxyConfig($proxy);

            if (is_null($outputDir)) {
                echo $config->prettyPrint(-1);
            } else {
                $fileName = $this->createFilename($proxy);
                $this->write($fileName, $config, $outputDir);
                $logger->debug(sprintf('%s as %s', $proxy->getNode()->getTitle(), $fileName));
            }
        }

        $logger->notice('Generate ended');
    }

    private function buildProxyConfig(Proxy $proxy)
    {
        return Scope::create()
            ->addDirective(Directive::create('server')
                ->setChildScope(Scope::create()
                    ->addDirective(Directive::create('listen', 80))
                    ->addDirective(Directive::create('server_name', $this->getServerName($proxy)))
                    ->addDirective(Directive::create('location', '/', Scope::create()
                        ->addDirective(Directive::create('proxy_pass', 'http://'.$proxy->getBackend().':'.$proxy->getPort()))
                        ->addDirective(Directive::create('proxy_set_header', 'Host $host'))
                        ->addDirective(Directive::create('proxy_set_header', 'X-Real-IP $remote_addr'))
                        ->addDirective(Directive::create('proxy_set_header', 'X-Forwarded-For $proxy_add_x_forwarded_for'))
                    ))
                )
            );
    }

    private function getServerName(Proxy $proxy)
    {
        return implode(' ', array_map(function(Domain $domain) {
            return $domain->getFqdn();
        }, $proxy->getDomains()->getValues()));
    }

    private function write($fileName, Scope $scope, $outputDir)
    {
        $scope->saveToFile($outputDir.$fileName);
    }

    private function createFilename(Proxy $proxy)
    {
        return preg_replace('/[^a-z\.-]+/', '-', $proxy->getNode()->getTitle().'.conf');
    }
}
