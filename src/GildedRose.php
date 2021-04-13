<?php

namespace App;

class GildedRose
{
    private $items;

    const MAX_QUALITY = 50;
    const MIN_QUALITY = 0;
    const MIN_SELLIN = 0;
    const SULFURAS = 'Sulfuras, Hand of Ragnaros';
    const BRIE = 'Aged Brie';
    const BACKSTAGE_PASSES = 'Backstage passes to a TAFKAL80ETC concert';
    const BACKSTAGE_PASS_QUALITY_INC_2 = 10;
    const BACKSTAGE_PASS_QUALITY_INC_3 = 5;

    /**
     * GildedRose constructor.
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param null $which
     * @return array|mixed
     */
    public function getItem($which = null)
    {
        return ($which === null
            ? $this->items
            : $this->items[$which]
        );
    }

    /**
     * Update the inventory after each day
     */
    public function nextDay()
    {
        foreach ($this->items as $item) {
            if ($this->isLegendary($item)) {
                continue;
            }

            $this->updateQuality($item);
            --$item->sellIn;
            if ($item->sellIn < self::MIN_SELLIN) {
                $this->updateQuality($item, true);
            }
        }
    }

    /**
     * Check whether the item is a legendary item
     *
     * @param $item
     * @return bool
     */
    private function isLegendary($item) {
        return $item->name === self::SULFURAS;
    }

    /**
     *
     * Update item quality value
     *
     * This is based on item type, it's sellin value, and whether the sellin value has passed
     *
     * @param $item
     * @param false $passed_sell_in
     */
    private function updateQuality($item, $passed_sell_in = false) {

        if ($item->name === self::BRIE) {
            $quality = 1;
        } else if ($item->name === self::BACKSTAGE_PASSES) {
            $quality = 1;
            if ($passed_sell_in) {
                $quality = -($item->quality);
            } else {
                if ($item->sellIn <= self::BACKSTAGE_PASS_QUALITY_INC_2) {
                    $quality = 2;
                }
                if ($item->sellIn <= self::BACKSTAGE_PASS_QUALITY_INC_3) {
                    $quality = 3;
                }
            }
        } else {
            $quality = -1;
        }
        $item->quality += $quality;

        // Quality can never go beyond the min/max values.  Set it to those values if it has.
        if ($item->quality < self::MIN_QUALITY) {
            $item->quality = self::MIN_QUALITY;
        } else if ($item->quality > self::MAX_QUALITY) {
            $item->quality = self::MAX_QUALITY;
        }
    }

}
