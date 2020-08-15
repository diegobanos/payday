<?php

declare(strict_types=1);

namespace Diegobanos\Payday;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;

class Transaction
{
    protected Member $creditor;

    /**
     * @var ArrayCollection<int, Member>
     */
    protected ArrayCollection $debtors;

    protected float $amount;

    protected DateTimeImmutable $createdAt;

    /**
     * @param ArrayCollection<int, Member> $debtors
     */
    public function __construct(Member $creditor, ArrayCollection $debtors, float $amount)
    {
        $this->creditor = $creditor;
        $this->debtors = $debtors;
        $this->amount = $amount;
        $this->createdAt = new DateTimeImmutable();
    }

    public function getCreditor(): Member
    {
        return $this->creditor;
    }

    /**
     * @return ArrayCollection<int, Member>
     */
    public function getDebtors(): ArrayCollection
    {
        return $this->debtors;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
