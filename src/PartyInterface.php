<?php

declare(strict_types=1);

namespace Diegobanos\Payday;

use Doctrine\Common\Collections\ArrayCollection;

interface PartyInterface
{
    public function getName(): string;

    /**
     * @return ArrayCollection<int, MemberInterface>
     */
    public function getMembers(): ArrayCollection;

    /**
     * @return MemberInterface|false
     */
    public function getMember(string $name);

    /**
     * @return ArrayCollection<int, TransactionInterface>
     */
    public function getTransactions(): ArrayCollection;

    /**
     * @return ArrayCollection<int, DebtInterface>
     */
    public function getDebts(): ArrayCollection;

    public function addMember(string $name): self;

    public function removeMember(MemberInterface $member): self;

    public function addTransaction(TransactionInterface $transaction): self;

    public function updateDebts(): self;

    public function removeDebt(DebtInterface $debt): self;
}
