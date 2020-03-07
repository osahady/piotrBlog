<?php
namespace App\Services;

use App\Contracts\CounterContract;

Class DummyCounter implements CounterContract
{
  public function increment(string $key, array $tags = null) : int
  {
    dd("I'm a dummy counter not implemnted yet!");
    return 0;
  }
  
}