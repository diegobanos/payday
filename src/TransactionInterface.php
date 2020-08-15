<?php

declare(strict_types=1);

namespace Diegobanos\Payday;

use Doctrine\Common\Collections\Collection;

interface TransactionInterface
{
    public function getCreditor(): MemberInterface;

    /**
     * @return Collection<int, MemberInterface>
     */
    public function getDebtors(): Collection;

    public function getAmount(): float;
}
