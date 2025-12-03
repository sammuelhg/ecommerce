<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\ProductType;

trait ProductKitTrait
{
    public $isKit = false;
    public $bundleItems = [];
    public $productSearch = '';

    public function checkIfKit()
    {
        if ($this->product_type_id) {
            $type = ProductType::find($this->product_type_id);
            $this->isKit = ($type && $type->code === 'KIT');
        } else {
            $this->isKit = false;
        }
    }

    public function updatedProductSearch()
    {
        $this->resetPage('kit_page');
    }

    public function toggleBundleItem($productId)
    {
        $index = $this->getBundleItemIndex($productId);

        if ($index !== false) {
            // Remove
            $this->removeFromBundle($index);
        } else {
            // Add
            $product = Product::find($productId);
            if ($product) {
                $this->bundleItems[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => $product->price
                ];
            }
        }
    }

    public function isInBundle($productId)
    {
        return $this->getBundleItemIndex($productId) !== false;
    }

    protected function getBundleItemIndex($productId)
    {
        foreach ($this->bundleItems as $index => $item) {
            if ($item['product_id'] == $productId) {
                return $index;
            }
        }
        return false;
    }

    public function removeFromBundle($index)
    {
        unset($this->bundleItems[$index]);
        $this->bundleItems = array_values($this->bundleItems);
    }

    public function updateBundleQuantity($index, $qty)
    {
        if (isset($this->bundleItems[$index])) {
            $this->bundleItems[$index]['quantity'] = max(1, intval($qty));
        }
    }
}
