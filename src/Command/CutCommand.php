<?php
namespace Jerive\CsvTool\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
class CutCommand extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('cut')
            ->setDescription('Select a subset of columns')
            ->addOption('from', 'f', InputOption::VALUE_REQUIRED)
            ->addOption('to', 't', InputOption::VALUE_REQUIRED)
        ;
    }

    protected function execute(InputInterface $input)
    {
        $writer = $this->getWriter($input);
        $offset = $input->getOption('from');
        $length = $input->getOption('to') ? ($input->getOption('to') - $offset) : null;

        foreach($this->getReader($input, 0) as $data) {
            $writer->write(array_slice($data, $offset, $length));
        }
    }
}
