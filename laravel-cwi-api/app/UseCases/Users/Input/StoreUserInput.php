<?php

namespace App\UseCases\Users\Input;

class StoreUserInput
{
    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        public readonly array $payload,
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function from(array $payload): self
    {
        return new self($payload);
    }
}

