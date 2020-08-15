<?php

declare(strict_types=1);

namespace Diegobanos\Payday;

interface DebtInterface
{
    public function getCreditor(): MemberInterface;

    public function getDebtor(): MemberInterface;

    public function getAmount(): float;

    public function setAmount(float $amount): self;
}
