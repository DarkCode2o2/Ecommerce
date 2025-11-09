<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Detail - MadeByOmar')]
class ProductDetailPage extends Component
{

    public $slug;

    public function mount($slug) {
        return $this->slug = $slug;
    }

    public function render()
    {
        $product = Product::where('is_active', 1)->where('slug', $this->slug)->first();

        return view('livewire.product-detail-page', ['product' => $product]);
    }
}
