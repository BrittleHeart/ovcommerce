<?php

namespace App\Dto;

class Dto
{
    /**
     * @psalm-suppress MixedReturnTypeCoercion
     * @return array<string, scalar>
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function toJson(int $flags = JSON_PRETTY_PRINT): string
    {
        $encoded = json_encode($this->toArray(), $flags);
        if (false === $encoded) {
            throw new \LogicException('Could not convert this array to json format');
        }

        return $encoded;
    }

    public function __toString(): string
    {
        return $this->toJson();
    }
}
