<?php

declare(strict_types=1);

namespace Diegobanos\Payday;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

class Party
{
    protected string $name;

    /**
     * @var ArrayCollection<int, Member>
     */
    protected ArrayCollection $members;

    /**
     * @var ArrayCollection<int, Transaction>
     */
    protected ArrayCollection $transactions;

    /**
     * @var ArrayCollection<int, Debt>
     */
    protected ArrayCollection $debts;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->members = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->debts = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ArrayCollection<int, Member>
     */
    public function getMembers(): ArrayCollection
    {
        return $this->members;
    }

    /**
     * @return Member|false
     */
    public function getMember(string $name)
    {
        $criteria = Criteria::create()->where(Criteria::expr()->eq('name', $name));

        return $this->members->matching($criteria)->first();
    }

    /**
     * @return ArrayCollection<int, Transaction>
     */
    public function getTransactions(): ArrayCollection
    {
        return $this->transactions;
    }

    /**
     * @return ArrayCollection<int, Debt>
     */
    public function getDebts(): ArrayCollection
    {
        return $this->debts;
    }

    public function addMember(string $name): self
    {
        $criteria = Criteria::create()->where(Criteria::expr()->eq('name', $name));

        if ($this->members->matching($criteria)->isEmpty()) {
            $this->members->add(new Member($name));
        }

        return $this;
    }

    public function removeMember(Member $member): self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
        }

        return $this;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions->add($transaction);

            $transaction->getCreditor()->addBalance($transaction->getAmount());
            $debt = $transaction->getAmount() / $transaction->getDebtors()->count();

            foreach ($transaction->getDebtors() as $debtor) {
                $debtor->addBalance($debt * -1);
            }

            $this->updateDebts();
        }

        return $this;
    }

    public function updateDebts(): self
    {
        $this->debts->clear();

        $criteria = Criteria::create()->where(Criteria::expr()->gt('balance', 0))->orderBy(['balance' => 'DESC']);

        $positiveMembers = $this->members->matching($criteria);

        $criteria = Criteria::create()->where(Criteria::expr()->lt('balance', 0))->orderBy(['balance' => 'ASC']);

        $negativeMembers = $this->members->matching($criteria);

        $negativeBalances = [];

        foreach ($negativeMembers as $negativeMember) {
            $negativeBalances[$negativeMember->getName()] = abs($negativeMember->getBalance());
        }

        foreach ($positiveMembers as $positiveMember) {
            foreach ($negativeMembers as $negativeMember) {
                if ($negativeBalances[$negativeMember->getName()] <= 0.0) {
                    continue;
                }

                $debt = new Debt($positiveMember, $negativeMember);

                if ($positiveMember->getBalance() > $negativeBalances[$negativeMember->getName()]) {
                    $debt->setAmount($negativeBalances[$negativeMember->getName()]);
                    $negativeBalances[$negativeMember->getName()] = 0.0;
                    $this->debts->add($debt);
                } else {
                    $debt->setAmount($positiveMember->getBalance());
                    $negativeBalances[$negativeMember->getName()] -= $positiveMember->getBalance();
                    $this->debts->add($debt);
                    continue 2;
                }
            }
        }

        return $this;
    }

    public function removeDebt(Debt $debt): self
    {
        if ($this->debts->contains($debt)) {
            $debt->getCreditor()->addBalance($debt->getAmount() * -1);
            $debt->getDebtor()->addBalance($debt->getAmount());
            $this->debts->removeElement($debt);
        }

        return $this;
    }
}
