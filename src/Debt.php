<?php

declare(strict_types=1);

namespace Diegobanos\Payday;

class Debt
{
    protected Member $creditor;

    protected Member $debtor;

    protected float $amount;

    public function __construct(Member $creditor, Member $debtor)
    {
        $this->creditor = $creditor;
        $this->debtor = $debtor;
        $this->amount = 0.0;
    }

    public function getCreditor(): Member
    {
        return $this->creditor;
    }

    public function getDebtor(): Member
    {
        return $this->debtor;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
