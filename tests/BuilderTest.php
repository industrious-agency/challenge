<?php

namespace Tests;

use Industrious\Challenge\Builder;
use Industrious\Challenge\Exceptions\DuplicateIngredientException;
use Mockery;
use PHPUnit_Framework_TestCase;

class BuidlderTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tear down the test case.
     *
     * @return void
     */
    public function tearDown()
    {
        Mockery::close();
    }

    public function test_it_can_build_chocolate_cake()
    {
        $cake = Builder::start()
            ->addChocolate()
            ->make();

        $this->assertTrue($cake->isChocolate());
        $this->assertFalse($cake->isVanilla());
        $this->assertFalse($cake->hasGluten());
    }

    public function test_it_can_build_vanilla_cake()
    {
        $cake = Builder::start()
            ->addVanilla()
            ->make();

        $this->assertTrue($cake->isVanilla());
        $this->assertFalse($cake->isChocolate());
        $this->assertTrue($cake->hasGluten());
    }

    public function test_it_can_build_gluten_free_cake()
    {
        $cake = Builder::start()
            ->make();

        $this->assertTrue($cake->hasGluten());
    }

    public function test_it_can_build_mocha_cake()
    {
        $cake = Builder::start()
            ->addChocolate()
            ->addCoffee()
            ->make();

        $this->assertTrue($cake->isMocha());
        $this->assertTrue($cake->isChocolate());
        $this->assertTrue($cake->isCoffee());
        $this->assertFalse($cake->isVanilla());
    }

    public function test_it_cant_add_multiple_of_the_same_ingredient()
    {
        $this->expectException(DuplicateIngredientException::class);

        $cake = Builder::start()
            ->addChocolate()
            ->addChocolate()
            ->make();
    }

    public function test_it_can_be_caffeine_free()
    {
        $cake = Builder::start()
            ->addCoffee(true)
            ->make();

        $this->assertTrue($cake->isCoffee());
        $this->assertFalse($cake->hasCaffeine());
    }
}
