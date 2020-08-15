<?php

declare(strict_types=1);

namespace Tests\Diegobanos\Payday;

use Diegobanos\Payday\Member;
use Diegobanos\Payday\Transaction;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Diegobanos\Payday\Member
 * @covers \Diegobanos\Payday\Transaction
 */
class TransactionTest extends TestCase
{
    const DELTA = 0.000001;

    public function testCreateTransaction(): void
    {
        $creditor = new Member('Creditor');
        $debtor = new Member('Debtor');
        $debtors = new ArrayCollection();
        $debtors->add($debtor);
        $transaction = new Transaction($creditor, $debtors, 5.0);

        self::assertEquals($creditor, $transaction->getCreditor());
        self::assertEquals($debtors, $transaction->getDebtors());
        self::assertEqualsWithDelta(5.0, $transaction->getAmount(), self::DELTA);
    }
}
