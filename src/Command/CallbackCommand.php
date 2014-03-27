<?php
namespace Jerive\CsvTool\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

class CallbackCommand extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('callback')
            ->setDescription('Execute a PHP callback for each line of the CSV. The callback is provided acces to $row and $reader variables')
            ->addOption('callback', 'c', InputOption::VALUE_REQUIRED, 'The PHP callback as a one liner')
        ;
    }

    protected function execute(InputInterface $input)
    {
        if (!$input->getOption('callback')) {
            throw new \RuntimeException('You have to provide a callback via the --callback option');
        }

        $line   = $input->getOption('callback') . ';';
        $reader = $this->getReader($input, 0);

        $callback = function($row) use ($line, $reader) {
            eval($line);
        };

        foreach($reader as $data) {
            $callback($data);
        }
    }
}