<?php

declare(strict_types=1);

namespace Diegobanos\Payday;

use Doctrine\Common\Collections\Collection;

interface PartyInterface
{
    public function getName(): string;

    /**
     * @return Collection<int, MemberInterface>
     */
    public function getMembers(): Collection;

    /**
     * @return MemberInterface|false
     */
    public function getMember(string $name);

    /**
     * @return Collection<int, TransactionInterface>
     */
    public function getTransactions(): Collection;

    /**
     * @return Collection<int, DebtInterface>
     */
    public function getDebts(): Collection;

    public function addMember(string $name): self;

    public function removeMember(MemberInterface $member): self;

    public function addTransaction(TransactionInterface $transaction): self;

    public function updateDebts(): self;

    public function removeDebt(DebtInterface $debt): self;
}
