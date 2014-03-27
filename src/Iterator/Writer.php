<?php
namespace Jerive\CsvTool\Iterator;

class Writer
{
    protected $handle;

    protected $delimiter = ',';

    protected $enclosure = '"';

    public function __construct($filename)
    {
        if ($filename === '-') {
            $filename = STDOUT;
        }

        $this->handle = is_resource($filename) ? $filename : fopen($filename, 'w');
    }

    /**
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escape
     */
    public function setCsvControl($delimiter = ',', $enclosure = '"')
    {
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;

        return $this;
    }

    public function write($data)
    {
        return fputcsv($this->handle, $data, $this->delimiter, $this->enclosure);
    }
}
