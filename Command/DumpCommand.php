<?php

namespace Funddy\Bundle\JsRoutingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @copyright (C) Funddy (2012)
 * @author Keyvan Akbary <keyvan@funddy.com>
 * @version 1.0
 */
class DumpCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('funddy:jsrouting:dump')
            ->setDefinition(array(
                new InputArgument('target', InputArgument::OPTIONAL, 'The target path', 'web/js/routes.js'),
            ))
            ->setDescription('Export exposed routes into a JavaScript file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $target = $input->getArgument('target');
        $exporter = $this->getContainer()->get('funddy.jsrouting.service.jsroutesexporter');

        if (@file_put_contents($target, $exporter->export()) === false) {
            throw new \RuntimeException(sprintf('Unable to write file "%s"', $target));
        }

        $output->writeln(sprintf('Wrote <comment>%s</comment>', $target));
    }
}
