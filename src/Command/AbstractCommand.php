<?php
namespace Jerive\CsvTool\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Jerive\CsvTool\Iterator\Reader;
use Jerive\CsvTool\Iterator\Writer;

class AbstractCommand extends Command
{
    protected function configure()
    {
        $this
            ->addOption('delimiter', 'sep', InputOption::VALUE_REQUIRED, 'The separator character', ',')
            ->addOption('enclosure', 'enc', InputOption::VALUE_REQUIRED, 'The enclosure character', '"')
            ->addOption('escape', 'esc', InputOption::VALUE_REQUIRED, 'The escape character', '\\')
            ->addOption('outputDelimiter', 'osep', InputOption::VALUE_REQUIRED, 'The separator character for output', ',')
            ->addOption('outputEnclosure', 'oenc', InputOption::VALUE_REQUIRED, 'The enclosure character for output', '"')
            ->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'The output (- for STDOUT)', '-')
            ->addOption('bufsize', 'b', InputOption::VALUE_REQUIRED, 'Buffer size for reading (0 = read until the end of the line)', 0)
            ->addArgument('files', InputArgument::IS_ARRAY, 'Input file')
        ;
    }

    /**
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param integer $i
     * @return \Jerive\CsvTool\Iterator\Reader
     */
    protected function getReader(InputInterface $input, $i = 0)
    {
        $files  = $input->getArgument('files');
        $reader = new Reader(isset($files[$i]) ? $files[$i] : '-');
        $reader->setBufferSize($input->getOption('bufsize'));
        $reader->setCsvControl(
                $input->getOption('delimiter'),
                $input->getOption('enclosure'),
                $input->getOption('escape')
        );

        return $reader;
    }

    /**
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @return \Jerive\CsvTool\Iterator\Writer
     */
    protected function getWriter(InputInterface $input)
    {
        $writer = new Writer($input->getOption('output'));
        $writer->setCsvControl(
                $input->getOption('outputDelimiter'),
                $input->getOption('outputEnclosure')
        );

        return $writer;
    }
}
