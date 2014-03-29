<?php
namespace Jerive\CsvTool\Iterator;

class Writer
{
    protected $handle;

    protected $delimiter = ',';

    protected $enclosure = '"';

    /**
     * @param <resource> $handle
     */
    public function __construct($handle)
    {
        $this->handle = $handle;
    }

    /**
     * @param <string> $delimiter
     * @param <string> $enclosure
     * @param <string> $escape
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
