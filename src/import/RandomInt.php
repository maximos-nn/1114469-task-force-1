<?php

namespace TaskForce\import;

class RandomInt
{
    protected $min;
    protected $max;

    public function __construct(int $min, int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function append(iterable $iterable): iterable
    {
        foreach ($iterable as $item) {
            $item[] = random_int($this->min, $this->max);
            yield $item;
        }
    }
}
