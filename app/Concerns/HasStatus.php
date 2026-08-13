<?php

namespace App\Concerns;

trait HasStatus
{
    public function activate()
    {
        $this->update(['status' => true]);
    }

    public function deactivate()
    {
        $this->update(['status' => false]);
    }
}
