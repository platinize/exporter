<?php

namespace App\Exporter;

interface Saveable
{
    public function save(string $fileName): void;
}