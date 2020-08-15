<?php

declare(strict_types=1);

namespace Diegobanos\Payday;

use Doctrine\Common\Collections\ArrayCollection;

interface TransactionInterface
{
    public function getCreditor(): MemberInterface;

    /**
     * @return ArrayCollection<int, MemberInterface>
     */
    public function getDebtors(): ArrayCollection;

    public function getAmount(): float;
}
