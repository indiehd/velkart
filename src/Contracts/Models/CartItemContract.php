<?php

namespace IndieHD\Velkart\Contracts\Models;

use Gloudemans\Shoppingcart\Contracts\Buyable;

interface CartItemContract
{
    /**
     * Returns the formatted weight.
     *
     * @param int $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function weight(
        $decimals = null,
        $decimalPoint = null,
        $thousandSeperator = null
    );

    /**
     * Returns the formatted price without TAX.
     *
     * @param int $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function price(
        $decimals = null,
        $decimalPoint = null,
        $thousandSeperator = null
    );

    /**
     * Returns the formatted price with discount applied.
     *
     * @param int $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function priceTarget(
        $decimals = null,
        $decimalPoint = null,
        $thousandSeperator = null
    );

    /**
     * Returns the formatted price with TAX.
     *
     * @param int $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function priceTax(
        $decimals = null,
        $decimalPoint = null,
        $thousandSeperator = null
    );

    /**
     * Returns the formatted subtotal.
     * Subtotal is price for whole CartItem without TAX.
     *
     * @param int $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function subtotal(
        $decimals = null,
        $decimalPoint = null,
        $thousandSeperator = null
    );

    /**
     * Returns the formatted total.
     * Total is price for whole CartItem with TAX.
     *
     * @param int $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function total(
        $decimals = null,
        $decimalPoint = null,
        $thousandSeperator = null
    );

    /**
     * Returns the formatted tax.
     *
     * @param int $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function tax(
        $decimals = null,
        $decimalPoint = null,
        $thousandSeperator = null
    );

    /**
     * Returns the formatted tax.
     *
     * @param int $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function taxTotal(
        $decimals = null,
        $decimalPoint = null,
        $thousandSeperator = null
    );

    /**
     * Returns the formatted discount.
     *
     * @param int $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function discount(
        $decimals = null,
        $decimalPoint = null,
        $thousandSeperator = null
    );

    /**
     * Returns the formatted total discount for this cart item.
     *
     * @param int $decimals
     * @param string $decimalPoint
     * @param string $thousandSeperator
     *
     * @return string
     */
    public function discountTotal(
        $decimals = null,
        $decimalPoint = null,
        $thousandSeperator = null
    );

    /**
     * Set the quantity for this cart item.
     *
     * @param int|float $qty
     */
    public function setQuantity($qty);

    /**
     * Update the cart item from a Buyable.
     *
     * @param \Gloudemans\Shoppingcart\Contracts\Buyable $item
     *
     * @return void
     */
    public function updateFromBuyable(Buyable $item);

    /**
     * Update the cart item from an array.
     *
     * @param array $attributes
     *
     * @return void
     */
    public function updateFromArray(array $attributes);

    /**
     * Associate the cart item with the given model.
     *
     * @param mixed $model
     *
     * @return \Gloudemans\Shoppingcart\CartItem
     */
    public function associate($model);

    /**
     * Set the tax rate.
     *
     * @param int|float $taxRate
     *
     * @return \Gloudemans\Shoppingcart\CartItem
     */
    public function setTaxRate($taxRate);

    /**
     * Set the discount rate.
     *
     * @param int|float $discountRate
     *
     * @return \Gloudemans\Shoppingcart\CartItem
     */
    public function setDiscountRate($discountRate);

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray();

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0);
}
