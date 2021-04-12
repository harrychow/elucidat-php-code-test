<?php

namespace App;

class GildedRose
{
    private $items;
    const MAX_QUALITY = 50;
    const MIN_QUALITY = 0;
    const SULFURAS = 'Sulfuras, Hand of Ragnaros';
    const BRIE = 'Aged Brie';
    const BACKSTAGE_PASSES = 'Backstage passes to a TAFKAL80ETC concert';

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function getItem($which = null)
    {
        return ($which === null
            ? $this->items
            : $this->items[$which]
        );
    }

    public function nextDay()
    {
        foreach ($this->items as $item) {
            if ($item->name != self::BRIE and $item->name != self::BACKSTAGE_PASSES) {
                if ($item->quality > self::MIN_QUALITY) {
                    if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                        $item->quality = $item->quality - 1;
                    }
                }
            } else {
                if ($item->quality < self::MAX_QUALITY) {
                    $item->quality = $item->quality + 1;
                    if ($item->name == self::BACKSTAGE_PASSES) {
                        if ($item->sellIn < 11) {
                            if ($item->quality < self::MAX_QUALITY) {
                                $item->quality = $item->quality + 1;
                            }
                        }
                        if ($item->sellIn < 6) {
                            if ($item->quality < self::MAX_QUALITY) {
                                $item->quality = $item->quality + 1;
                            }
                        }
                    }
                }
            }
            if ($item->name !== self::SULFURAS) {
                $item->sellIn = $item->sellIn - 1;
            }
            if ($item->sellIn < self::MIN_QUALITY) {
                if ($item->name != self::BRIE) {
                    if ($item->name != self::BACKSTAGE_PASSES) {
                        if ($item->quality > self::MIN_QUALITY) {
                            if ($item->name != self::SULFURAS) {
                                $item->quality = $item->quality - 1;
                            }
                        }
                    } else {
                        $item->quality = $item->quality - $item->quality;
                    }
                } else {
                    if ($item->quality < self::MAX_QUALITY) {
                        $item->quality = $item->quality + 1;
                    }
                }
            }
        }
    }
}
