<?php

namespace App\DTO;

readonly class SSHResult
{
    public function __construct(
        private bool $result,
        private string $output,
        private ?string $error = null,
    ) {}

    public function getResult(): bool
    {
        return $this->result;
    }

    public function getOutput(): string
    {
        return $this->output;
    }

    public function getError(): ?string
    {
        return $this->error;
    }
}
