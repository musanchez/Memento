<?php

namespace App\Memento;

class TareaCaretaker
{
    protected $mementoList = [];

    public function addMemento(TareaMemento $memento)
    {
        $this->mementoList[] = $memento;
    }

    public function getMemento($index)
    {
        return $this->mementoList[$index] ?? null;
    }
}
