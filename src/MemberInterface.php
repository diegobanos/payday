<?php

declare(strict_types=1);

namespace Diegobanos\Payday;

interface MemberInterface
{
    public function getName(): string;

    public function getBalance(): float;

    public function addBalance(float $amount): self;
}
