<?php

namespace App\Concerns;

trait HasPublish
{
    public function publish()
    {
        $this->update(['published_at' => now(), 'status' => true]);
    }

    public function draft()
    {
        $this->update(['status' => false]);
    }
}
