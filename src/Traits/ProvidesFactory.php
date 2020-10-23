<?php

namespace IndieHD\Velkart\Traits;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

trait ProvidesFactory
{
    public function factory(): Factory
    {
        $modelName = (string) Str::of('\\IndieHD\\Velkart\\Database\\Factories\\')
            ->append(class_basename($this->modelClass()))
            ->append('Factory');

        return $modelName::new();
    }
}
