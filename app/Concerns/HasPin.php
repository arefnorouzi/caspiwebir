<?php

namespace App\Concerns;

trait HasPin
{
    public function pin()
    {
        $this->update(['pinned' => true]);
    }

    public function unpin()
    {
        $this->update(['pinned' => false]);
    }
}
