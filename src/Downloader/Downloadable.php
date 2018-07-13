<?php

namespace App\Downloader;

use Generator;

interface Downloadable
{
    public function download(string ...$urls): Generator;
}