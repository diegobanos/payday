<?php

declare(strict_types=1);

namespace Tests\Diegobanos\Payday;

use Diegobanos\Payday\Member;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Diegobanos\Payday\Member
 */
class MemberTest extends TestCase
{
    const DELTA = 0.000001;

    public function testCreateMember(): void
    {
        $member = new Member('Member');

        self::assertEquals('Member', $member->getName());
        self::assertEqualsWithDelta(0.0, $member->getBalance(), self::DELTA);
    }

    public function testAddBalance(): void
    {
        $member = new Member('Member');

        $member->addBalance(-5.0);

        self::assertEquals('Member', $member->getName());
        self::assertEqualsWithDelta(-5.0, $member->getBalance(), self::DELTA);
    }
}
