<?php
namespace Jerive\CsvTool\Iterator;

class Wrapper implements \Iterator
{
    protected $iterator;

    public function __construct(\Iterator $iterator)
    {
        $this->iterator = $iterator;
    }

    public function current()
    {
        $this->iterator->current();
    }

    public function key()
    {
        $this->iterator->key();
    }

    public function next()
    {
        $this->iterator->next();
    }

    public function rewind()
    {
        $this->iterator->rewind();
    }

    public function valid()
    {
        $this->iterator->valid();
    }
}
