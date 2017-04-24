<?php

namespace Industrious\Challenge;

class Cake
{
    /**
     * The cake ingredients.
     *
     * @var array
     */
    protected $ingredients = [];

    /**
     * Creates a new cake.
     *
     * @param ...string $ingredients
     */
    public function __construct(...$ingredients)
    {
        $this->ingredients = $ingredients;
    }

    /**
     * Check if the cake is coffee.
     *
     * @return boolean
     */
    public function isCoffee()
    {
        return $this->hasIngredient('coffee');
    }

    /**
     * Check if the cake is chocolate.
     *
     * @return boolean
     */
    public function isChocolate()
    {
        return $this->hasIngredient('chocolate');
    }

    /**
     * Check if the cake is vanilla.
     *
     * @return boolean
     */
    public function isVanilla()
    {
        return $this->hasIngredient('vanilla');
    }

    /**
     * Check if the cake is mocha.
     *
     * @return boolean
     */
    public function isMocha()
    {
        return $this->isCoffee() && $this->isChocolate();
    }

    /**
     * Check if the cake is gluten free.
     *
     * @return boolean
     */
    public function hasGluten()
    {
        return ! $this->hasIngredient('gluten');
    }

    /**
     * Check if the cake is caffeine free.
     *
     * @return boolean
     */
    public function hasCaffeine()
    {
        return $this->hasIngredient('caffeine');
    }

    /**
     * Check if the cake has an ingredient.
     *
     * @param ...string $ingredients
     *
     * @return boolean
     */
    protected function hasIngredient(...$ingredients)
    {
        foreach ($ingredients as $ingredient) {
            if (in_array($ingredient, $this->ingredients)) {
                continue;
            }

            return false;
        }

        return true;
    }
}
