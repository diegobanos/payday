<?php

declare(strict_types=1);

namespace Diegobanos\Payday;

class Debt implements DebtInterface
{
    protected MemberInterface $creditor;

    protected MemberInterface $debtor;

    protected float $amount;

    public function __construct(MemberInterface $creditor, MemberInterface $debtor)
    {
        $this->creditor = $creditor;
        $this->debtor = $debtor;
        $this->amount = 0.0;
    }

    public function getCreditor(): MemberInterface
    {
        return $this->creditor;
    }

    public function getDebtor(): MemberInterface
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
