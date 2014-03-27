<?php
namespace Jerive\CsvTool\Command;

use Symfony\Component\Console\Input\InputInterface;

class AppendCommand extends AbstractCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('append')
            ->setDescription('Append the CSV files passed in input')
        ;
    }

    protected function execute(InputInterface $input)
    {
        $iterator = new \AppendIterator();
        $writer = $this->getWriter($input);

        foreach($input->getArgument('files') as $i => $file) {
            $iterator->append($this->getReader($input, $i));
        }

        foreach($iterator as $data) {
            $writer->write($data);
        }
    }
}