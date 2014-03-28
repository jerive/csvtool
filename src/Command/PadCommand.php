<?php
namespace Jerive\CsvTool\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

class PadCommand extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('pad')
            ->setDescription('Pad CSV lines to a specific length')
            ->addOption('length', 'l', InputOption::VALUE_REQUIRED, 'Pad length', 0)
        ;
    }

    protected function execute(InputInterface $input)
    {
        $reader = $this->getReader($input, 0);
        $writer = $this->getWriter($input);
        $size   = $input->getOption('length');

        foreach($reader as $data) {
            $writer->write(array_pad($data, $size, ''));
        }
    }
}
