<?php

namespace App\UseCases\Users\Input;

class UpdateUserInput
{
    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        public readonly int $id,
        public readonly array $payload,
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function from(int $id, array $payload): self
    {
        return new self($id, $payload);
    }
}

