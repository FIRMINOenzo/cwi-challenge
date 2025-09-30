<?php

namespace App\Contracts\UseCases;

/**
 * @template Input
 * @template Output
 */
interface UseCaseInterface
{
    /**
     * @param Input|null $input
     * @return Output
     */
    public function handle(mixed $input = null);
}

