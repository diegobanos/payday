<?php

declare(strict_types=1);

namespace Diegobanos\Payday;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;

class Transaction implements TransactionInterface
{
    protected MemberInterface $creditor;

    /**
     * @var ArrayCollection<int, MemberInterface>
     */
    protected ArrayCollection $debtors;

    protected float $amount;

    protected DateTimeImmutable $createdAt;

    /**
     * @param ArrayCollection<int, MemberInterface> $debtors
     */
    public function __construct(MemberInterface $creditor, ArrayCollection $debtors, float $amount)
    {
        $this->creditor = $creditor;
        $this->debtors = $debtors;
        $this->amount = $amount;
        $this->createdAt = new DateTimeImmutable();
    }

    public function getCreditor(): MemberInterface
    {
        return $this->creditor;
    }

    /**
     * @return ArrayCollection<int, MemberInterface>
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
