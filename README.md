# payday

Payday is a management payment tools for a group of friends.

Create a party with a list of members, add transactions as each members makes a payment for one or more members of the group, and get an updated list of debts to be settled!

## Installation

### Composer

``` composer require diegobanos/payday ```

## Example

```
<?php


use Diegobanos\Payday\Debt;
use Diegobanos\Payday\Member;
use Diegobanos\Payday\Party;
use Diegobanos\Payday\Transaction;

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

$party->getDebts() /** It will output two debts. Debtor 1 owes 5.0 to Collector and Debtor 2 owes 5.0 to Collector. */

/** @var Debt $debt */
$debt = $party->getDebts()->first();

$party->removeDebt($debt);

$party->getDebts() /** It will output one debt. Debtor 2 owes 5.0 to Collector. */
```
