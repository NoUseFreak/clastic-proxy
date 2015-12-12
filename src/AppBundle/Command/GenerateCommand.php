<?php
/**
 * Created by PhpStorm.
 * User: ddepeuter
 * Date: 12/12/15
 * Time: 00:31
 */

namespace AppBundle\Command;

use AppBundle\Proxy\Generator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('proxy:generate')
            ->setDescription('Greet someone')
            ->addArgument(
                'dir',
                InputArgument::OPTIONAL,
                'Where should the files be stored?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = new ConsoleLogger($output);

        $generator = $this->getContainer()->get('app_bundle.generator');
        $generator->generate($logger, $input->getArgument('dir'));
    }
}