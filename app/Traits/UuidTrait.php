<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait UuidTrait
{
    public function UuidTrait(): void
    {
        $this->keyType = 'string';
        $this->id = Str::orderedUuid()->toString();
    }
}
