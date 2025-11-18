<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Detail - MadeByOmar')]
class ProductDetailPage extends Component
{

    public $slug;
    public $quantity = 1; 

    public function increaseQty() {
        $this->quantity++;
    }

    public function decreaseQty() {
        if($this->quantity > 1) {
            $this->quantity--;
        }
    }

    // Add to cart method with qty
    public function addToCart($product_id) {
        $total_count = CartManagement::addItemToCartWithQty($product_id, $this->quantity); 

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        
        LivewireAlert::title('Success!')
            ->text('Product Added To Cart Successfully')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }


    public function mount($slug) {
        return $this->slug = $slug;
    }

    public function render()
    {
        $product = Product::where('is_active', 1)->where('slug', $this->slug)->first();

        return view('livewire.product-detail-page', ['product' => $product]);
    }

}
