<?php

namespace App\Contracts\Services;

interface ExternalServiceClientInterface
{
    /**
     * @return array<string, mixed>
     */
    public function fetch(): array;
}

