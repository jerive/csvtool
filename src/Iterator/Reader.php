<?php
namespace Jerive\CsvTool\Iterator;

class Reader implements \SeekableIterator
{
    /**
     * @var resource
     */
    protected $handle;

    protected $delimiter = ',';

    protected $enclosure = '"';

    protected $escape = '\\';

    protected $line = 0;

    protected $bufsize = 0;

    protected $hasHeader = false;

    protected $current = null;

    protected $header;

    /**
     * @param <string|resource> $filename
     */
    public function __construct($filename)
    {
        if ($filename === '-') {
            $filename = STDIN;
        }

        $this->handle = is_resource($filename) ? $filename : fopen($filename, 'r');
    }

    /**
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escape
     */
    public function setCsvControl($delimiter = ',', $enclosure = '"', $escape = '\\')
    {
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->escape    = $escape;

        return $this;
    }

    public function setBufferSize($size = 0)
    {
        $this->bufsize = $size;

        return $this;
    }

    public function setHasHeader($has = true)
    {
        $this->hasHeader = $has;

        return $this;
    }

    /**
     * @return <bool>
     */
    public function hasHeader()
    {
        return $this->hasHeader;
    }

    /**
     * @return <array|false>
     */
    public function current()
    {
        if (0 === $this->line) {
            $this->next();
        }

        return $this->current;
    }

    public function key()
    {
        return $this->line;
    }

    public function next()
    {
        $this->current = fgetcsv($this->handle, $this->bufsize, $this->delimiter, $this->enclosure, $this->escape);
        $this->line++;

        if (1 === $this->line && $this->hasHeader) {
            $this->header = $this->current;
            $this->next();
        }
    }

    public function rewind()
    {
        rewind($this->handle);
    }

    public function valid()
    {
        return $this->current !== false;
    }

    public function seek($position)
    {
        if ($position < $this->line) {
            $this->rewind();
        }

        do {
            $this->next();
        } while ($position >= $this->line);
    }

    public function getHeader()
    {
        if (!$this->hasHeader) {
            throw new \Exception('This file is not supposed to have a header');
        }

        if (!isset($this->header)) {
            $this->current();
        }

        return $this->header;
    }
}
