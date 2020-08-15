<?php

declare(strict_types=1);

namespace Tests\Diegobanos\Payday;

use Diegobanos\Payday\Debt;
use Diegobanos\Payday\Member;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Diegobanos\Payday\Debt
 * @covers \Diegobanos\Payday\Member
 */
class DebtTest extends TestCase
{
    const DELTA = 0.000001;

    public function testCreateDebt(): void
    {
        $creditor = new Member('Creditor');
        $debtor = new Member('Debtor');
        $debt = new Debt($creditor, $debtor);

        self::assertEquals($creditor, $debt->getCreditor());
        self::assertEquals($debtor, $debt->getDebtor());
        self::assertEqualsWithDelta(0.0, $debt->getAmount(), self::DELTA);
    }

    public function testUpdateDebt(): void
    {
        $creditor = new Member('Creditor');
        $debtor = new Member('Debtor');
        $debt = new Debt($creditor, $debtor);

        $debt->setAmount(5.0);

        self::assertEquals($creditor, $debt->getCreditor());
        self::assertEquals($debtor, $debt->getDebtor());
        self::assertEqualsWithDelta(5.0, $debt->getAmount(), self::DELTA);
    }
}
