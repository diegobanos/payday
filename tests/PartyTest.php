<?php

namespace Tests\Diegobanos\Payday;

use Diegobanos\Payday\Debt;
use Diegobanos\Payday\Member;
use Diegobanos\Payday\Party;
use Diegobanos\Payday\Transaction;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Diegobanos\Payday\Debt
 * @covers \Diegobanos\Payday\Member
 * @covers \Diegobanos\Payday\Party
 * @covers \Diegobanos\Payday\Transaction
 */
class PartyTest extends TestCase
{
    const DELTA = 0.000001;

    public function testCreateParty(): void
    {
        $party = new Party('Party');

        self::assertEquals('Party', $party->getName());
        self::assertEmpty($party->getMembers()->toArray());
        self::assertEmpty($party->getTransactions()->toArray());
        self::assertEmpty($party->getDebts()->toArray());
    }

    public function testAddMember(): void
    {
        $party = new Party('Party');
        $party->addMember('Member');

        self::assertCount(1, $party->getMembers()->toArray());
        self::assertIsObject($party->getMember('Member'));
    }

    public function testRemoveMember(): void
    {
        $party = new Party('Party');
        $party->addMember('Member');

        /** @var Member $member */
        $member = $party->getMember('Member');
        $party->removeMember($member);

        self::assertEmpty($party->getMembers()->toArray());
    }

    public function testAddTransaction(): void
    {
        $party = new Party('Party');
        $party->addMember('Creditor');
        $party->addMember('Debtor 1');
        $party->addMember('Debtor 2');

        /** @var Member $creditor */
        $creditor = $party->getMember('Creditor');
        $debtors = new ArrayCollection();

        /** @var Member $debtor1 */
        $debtor1 = $party->getMember('Debtor 1');
        $debtors->add($debtor1);

        /** @var Member $debtor2 */
        $debtor2 = $party->getMember('Debtor 2');
        $debtors->add($debtor2);

        $transaction = new Transaction($creditor, $debtors, 10.0);

        $party->addTransaction($transaction);

        self::assertCount(1, $party->getTransactions()->toArray());
        self::assertEqualsWithDelta(10.0, $creditor->getBalance(), self::DELTA);
        self::assertEqualsWithDelta(-5.0, $debtor1->getBalance(), self::DELTA);
        self::assertEqualsWithDelta(-5.0, $debtor2->getBalance(), self::DELTA);
        self::assertCount(2, $party->getDebts()->toArray());
        self::assertEquals($creditor, $party->getDebts()->toArray()[0]->getCreditor());
        self::assertEquals($debtor1, $party->getDebts()->toArray()[0]->getDebtor());
        self::assertEqualsWithDelta(5.0, $party->getDebts()->toArray()[0]->getAmount(), self::DELTA);
        self::assertEquals($creditor, $party->getDebts()->toArray()[1]->getCreditor());
        self::assertEquals($debtor2, $party->getDebts()->toArray()[1]->getDebtor());
        self::assertEqualsWithDelta(5.0, $party->getDebts()->toArray()[1]->getAmount(), self::DELTA);
    }

    public function testRemoveDebt(): void
    {
        $party = new Party('Party');
        $party->addMember('Creditor');
        $party->addMember('Debtor 1');
        $party->addMember('Debtor 2');

        /** @var Member $creditor */
        $creditor = $party->getMember('Creditor');
        $debtors = new ArrayCollection();

        /** @var Member $debtor1 */
        $debtor1 = $party->getMember('Debtor 1');
        $debtors->add($debtor1);

        /** @var Member $debtor2 */
        $debtor2 = $party->getMember('Debtor 2');
        $debtors->add($debtor2);

        $transaction = new Transaction($creditor, $debtors, 10.0);

        $party->addTransaction($transaction);

        /** @var Debt $debt */
        $debt = $party->getDebts()->first();

        $party->removeDebt($debt);

        self::assertCount(1, $party->getTransactions()->toArray());
        self::assertEqualsWithDelta(5.0, $creditor->getBalance(), self::DELTA);
        self::assertEqualsWithDelta(0.0, $debtor1->getBalance(), self::DELTA);
        self::assertEqualsWithDelta(-5.0, $debtor2->getBalance(), self::DELTA);
        self::assertCount(1, $party->getDebts()->toArray());
    }
}
