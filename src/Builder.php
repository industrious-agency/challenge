<?php

namespace Industrious\Challenge;

use Industrious\Challenge\Exceptions\DuplicateIngredientException;

class Builder
{
    /**
     * The ingredients to add to the cake.
     *
     * @var array
     */
    protected $ingredients = [];

    /**
     * Start a new cake builder.
     *
     * @return \Industrious\Challenge\Builder
     */
    public static function start()
    {
        return new self;
    }

    /**
     * Add an ingredient.
     *
     * @param string $ingredients
     */
    protected function add(...$ingredients)
    {
        if (! empty($this->ingredients)) {
            array_push($ingredients, ...$this->ingredients);
        }

        $unique = array_unique($ingredients);

        if (count($ingredients) !== count($unique)) {
            throw new DuplicateIngredientException();
        }

        $this->ingredients = $ingredients;

        return $this;
    }

    /**
     * Add chocolate.
     *
     * @return void
     */
    public function addChocolate()
    {
        return $this->add('chocolate', 'gluten');
    }

    /**
     * Add vanilla.
     *
     * @return void
     */
    public function addVanilla()
    {
        return $this->add('vanilla');
    }

    /**
     * Add coffee.
     *
     * @param bool $decafe
     *
     * @return void
     */
    public function addCoffee($decafe = false)
    {
        if (! $decafe) {
            $this->add('caffeine');
        }

        return $this->add('coffee');
    }

    /**
     * Actually make the cake.
     *
     * @return Industrious\Challenge\Cake
     */
    public function make()
    {
        return new Cake(...$this->ingredients);
    }
}
