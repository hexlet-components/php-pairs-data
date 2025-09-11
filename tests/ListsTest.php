<?php

namespace Php\Pairs\Data\tests;

use PHPUnit\Framework\TestCase;

use function Php\Pairs\Pairs\cons as pairsCons;
use function Php\Pairs\Pairs\car;
use function Php\Pairs\Pairs\cdr;
use function Php\Pairs\Data\Lists\toString;
use function Php\Pairs\Data\Lists\length;
use function Php\Pairs\Data\Lists\reverse;
use function Php\Pairs\Data\Lists\l;
use function Php\Pairs\Data\Lists\cons;
use function Php\Pairs\Data\Lists\map;
use function Php\Pairs\Data\Lists\filter;
use function Php\Pairs\Data\Lists\reduce;
use function Php\Pairs\Data\Lists\isList;
use function Php\Pairs\Data\Lists\checkList;
use function Php\Pairs\Data\Lists\head;
use function Php\Pairs\Data\Lists\tail;
use function Php\Pairs\Data\Lists\isEmpty;
use function Php\Pairs\Data\Lists\isEqual;
use function Php\Pairs\Data\Lists\has;
use function Php\Pairs\Data\Lists\s;
use function Php\Pairs\Data\Lists\conj;
use function Php\Pairs\Data\Lists\disj;
use function Php\Pairs\Data\Lists\concat;
use function Php\Pairs\Data\Lists\random;

class ListsTest extends TestCase
{
    public function testL(): void
    {
        $this->assertEquals(toString(l()), toString(l()));
        $list = cons(1, cons((cons(3, cons(4, null))), cons(5, null)));
        $this->assertEquals(toString($list), toString(l(1, l(3, 4), 5)));
    }

    public function testHead(): void
    {
        $this->assertEquals(3, head(l(3, 4, 5)));
        $this->expectExceptionMessage("Argument must be list, but it was '5'");
        head(5);
    }

    public function testTail(): void
    {
        $this->assertEquals('(4, 5)', toString(tail(l(3, 4, 5))));
        $this->expectExceptionMessage("Argument must be list, but it was 'array'");
        tail([]);
    }

    public function testIsEmpty(): void
    {
        $this->assertTrue(isEmpty(l()));
        $this->assertFalse(isEmpty(l(0)));
    }

    public function testIsEqual(): void
    {
        $numbers = l(3, 4, 5, 8);
        $numbers2 = l(3, 4, 5, 8);
        $numbers3 = l(3, 2, 9);

        $this->assertTrue(isEqual($numbers, $numbers2));
        $this->assertFalse(isEqual($numbers2, $numbers3));
    }

    public function testHas(): void
    {
        $numbers = l(3, 4, 5, 8);

        $this->assertTrue(has($numbers, 3));
        $this->assertTrue(has($numbers, 8));
        $this->assertFalse(has($numbers, 0));
        $this->assertFalse(has($numbers, 7));
    }

    public function testFilter(): void
    {
        $list = l(2, 3, 4);
        $expected = toString(l(2, 4));
        $filter = filter($list, fn($x) => $x % 2 == 0);

        $this->assertEquals(2, length($filter));
        $this->assertEquals($expected, toString($filter));

        $list2 = l();
        $expected = toString(l());
        $filtered = filter($list2, fn($x) => $x % 2 == 0);
        $this->assertEquals($expected, toString($filtered));
    }

    public function testS(): void
    {
        $numbers = s(3, 4, 3, 5, 5);
        $this->assertEquals('(4, 3, 5)', toString($numbers));

        $empty = s();
        $this->assertEquals('()', toString($empty));
    }

    public function testConj(): void
    {
        $numbers = s(3, 4, 3, 5, 5);
        $numbers2 = conj($numbers, 0);

        $this->assertFalse(has($numbers, 0));
        $this->assertTrue(has($numbers2, 0));
    }

    public function testDisj(): void
    {
        $numbers = s(3, 4, 3, 5, 5);
        $numbers2 = disj($numbers, 4);

        $this->assertTrue(has($numbers, 4));
        $this->assertFalse(has($numbers2, 4));
    }

    public function testIsList(): void
    {
        $numbers = l(3, 4, 5);
        $this->assertTrue(isList($numbers));
        $this->assertTrue(isList(l()));
        $this->assertTrue(!isList(pairsCons(3, pairsCons(3, 2))));
        $this->assertFalse(isList(5));
    }

    public function testCheckList(): void
    {
        $this->expectExceptionMessage("Argument must be list, but it was 'pair: (1, (2, 3))'");
        checkList(pairsCons(1, pairsCons(2, 3)));
    }

    public function testConcat(): void
    {
        $numbers = l(3, 4, 5, 8);
        $numbers2 = l(3, 2, 9);

        $this->assertEquals('(3, 4, 5, 8, 3, 2, 9)', toString(concat($numbers, $numbers2)));
        $this->assertEquals('(1, 10)', toString(concat(l(), l(1, 10))));
        $this->assertEquals('(1, 10)', toString(concat(l(1, 10), l())));
    }

    public function testLength(): void
    {
        $this->assertEquals(0, length(l()));
        $list = l(1, 2, 3);
        $this->assertEquals(3, length($list));
    }

    public function testReverse(): void
    {
        $this->assertEquals(toString(l()), toString(reverse(l())));

        $list = l(1, 2, 3);
        $expected = toString(l(3, 2, 1));
        $this->assertEquals($expected, toString(reverse($list)));
    }

    public function testMap(): void
    {
        $list = l(1, 2, 3);
        $expected = toString(l(3, 4, 5));
        $map = map($list, fn($x) => $x + 2);
        $this->assertEquals($expected, toString($map));

        $list2 = l();
        $map = map($list2, fn($x) => $x + 2);
        $this->assertEquals(toString(l()), toString($map));
    }

    public function testReduce(): void
    {
        $list = l(1, 2, 3);
        $expected = 6;
        $reduced = reduce($list, fn($x, $acc) => $x + $acc, 0);
        $this->assertEquals($expected, $reduced);

        $list2 = l();
        $expected = null;
        $reduced2 = reduce($list2, fn($x, $acc) => $x + $acc);
        $this->assertEquals($expected, $reduced2);
    }


    public function testRandom(): void
    {
        $numbers = l(3, 4, 3, 5, 5);
        $randomNumber = random($numbers);
        $this->assertTrue(has($numbers, $randomNumber));
        $this->assertEquals(3, random(l(3)));
    }

    public function testToString(): void
    {
        $this->assertEquals('()', toString(l()));

        $list = l(3, l(4, 5), l(10, l(3)), 5, 5);
        $this->assertEquals('(3, (4, 5), (10, (3)), 5, 5)', toString($list));

        $list2 = l(3, pairsCons(4, 5), pairsCons(10, 3), 5, 5);
        $this->assertEquals('(3, pair: (4, 5), pair: (10, 3), 5, 5)', toString($list2));
    }
}
