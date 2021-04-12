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

    private function isLegendary($item) {
        return $item->name === self::SULFURAS;
    }

    private function updateSellin($item) {

    }

    private function updateQuality($item) {

    }

    public function nextDay()
    {
        foreach ($this->items as $item) {
            $this->updateSellin($item);
            $this->updateQuality($item);

            if ($item->name !== self::BRIE && $item->name !== self::BACKSTAGE_PASSES) {
                if (($item->quality > self::MIN_QUALITY) && !$this->isLegendary($item)) {
                    --$item->quality;
                }
            } else if ($item->quality < self::MAX_QUALITY) {
                ++$item->quality;
                if ($item->name === self::BACKSTAGE_PASSES) {
                    if ($item->sellIn < 11) {
                        if ($item->quality < self::MAX_QUALITY) {
                            ++$item->quality;
                        }
                    }
                    if ($item->sellIn < 6) {
                        if ($item->quality < self::MAX_QUALITY) {
                            ++$item->quality;
                        }
                    }
                }
            }
            if (!$this->isLegendary($item)) {
                --$item->sellIn;
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
