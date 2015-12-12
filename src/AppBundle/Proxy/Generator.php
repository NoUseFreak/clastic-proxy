<?php
/**
 * Created by PhpStorm.
 * User: ddepeuter
 * Date: 12/12/15
 * Time: 00:35.
 */
namespace AppBundle\Proxy;

use AppBundle\Proxy\Handler\HandlerInterface;
use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Psr\Log\LoggerInterface;
use RomanPitak\Nginx\Config\Scope;

class Generator
{
    /**
     * @var HandlerInterface[]
     */
    private $handlers;

    public function __construct($handlers = [])
    {
        $this->handlers = $handlers;
    }

    public function addHandler(HandlerInterface $handler)
    {
        $this->handlers[] = $handler;
    }

    /**
     * @param LoggerInterface $logger
     * @param null            $outputDir
     */
    public function generate(LoggerInterface $logger, $outputDir = null)
    {
        $logger->notice('Generate started');

        if (!is_null($outputDir)) {
            $logger->notice('Cleaning dir.');
            $outputDir = realpath($outputDir).'/';

            foreach (glob($outputDir.'*') as $file) {
                unlink($file);
            }
        }

        foreach ($this->handlers as $handler) {
            $handlerName = basename(str_replace(['\\', 'Handler'], '/', get_class($handler)));
            $logger->notice(sprintf('Generating %s', $handlerName));
            foreach ($handler->getRecords() as $record) {
                $config = $handler->buildConfig($record);

                if (is_null($outputDir)) {
                    echo $config->prettyPrint(-1);
                } else {
                    $fileName = $handlerName.'-'.$this->createFilename($record);
                    $this->write($fileName, $config, $outputDir);
                    $logger->debug(sprintf('%s as %s', $record->getNode()->getTitle(), $fileName));
                }
            }
        }

        $logger->notice('Generate ended');
    }

    private function write($fileName, Scope $scope, $outputDir)
    {
        $scope->saveToFile($outputDir.$fileName);
    }

    private function createFilename(NodeReferenceInterface $proxy)
    {
        return preg_replace('/[^a-z\.-]+/', '-', $proxy->getNode()->getTitle().'.conf');
    }
}
