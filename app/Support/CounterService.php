<?php

namespace App\Support;

class CounterService
{
    private $count = 0;

    public function increment()
    {
        $this->count++;
        return $this->count;
    }


}
