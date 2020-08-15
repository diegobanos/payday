<?php

declare(strict_types=1);

namespace Diegobanos\Payday;

use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;

class Transaction implements TransactionInterface
{
    protected MemberInterface $creditor;

    /**
     * @var Collection<int, MemberInterface>
     */
    protected Collection $debtors;

    protected float $amount;

    protected DateTimeImmutable $createdAt;

    /**
     * @param Collection<int, MemberInterface> $debtors
     */
    public function __construct(MemberInterface $creditor, Collection $debtors, float $amount)
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
     * @return Collection<int, MemberInterface>
     */
    public function getDebtors(): Collection
    {
        return $this->debtors;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
