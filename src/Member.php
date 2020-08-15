<?php

declare(strict_types=1);

namespace Diegobanos\Payday;

class Member implements MemberInterface
{
    protected string $name;

    protected float $balance;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->balance = 0.0;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function addBalance(float $amount): self
    {
        $this->balance += $amount;

        return $this;
    }
}
