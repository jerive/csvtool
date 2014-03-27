<?php
namespace Jerive\CsvTool\Command;

use Symfony\Component\Console\Input\InputInterface;

class MergeCommand extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('merge')
            ->setDescription('Merge the csv files passed as input')
        ;
    }

    protected function execute(InputInterface $input)
    {
        $iterator = new \MultipleIterator();
        $writer = $this->getWriter($input);

        foreach($input->getArgument('files') as $i => $file) {
            $iterator->attachIterator($this->getReader($input, $i));
        }

        foreach($iterator as $data) {
            $writer->write(call_user_func_array('array_merge', $data));
        }
    }
}
