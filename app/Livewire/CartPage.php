<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Cart Item - MadeByOmar")]
class CartPage extends Component
{
    public $cart_items = []; 
    public $total_grand; 

    public function mount() {
        $this->cart_items = CartManagement::getCartItemsFromCookie();
        $this->total_grand = CartManagement::getGrandTotal($this->cart_items);
    }
    
    // Remove item from cart 
    public function removeItem($product_id) {
        $this->cart_items = CartManagement::removeCartItem($product_id);
        $this->total_grand = CartManagement::getGrandTotal($this->cart_items);

        $this->dispatch('update-cart-count', total_count: count($this->cart_items))->to(Navbar::class);
    }

    public function increaseQty($product_id) {
        $this->cart_items = CartManagement::incrementItemQuantityInCartItem($product_id);
        $this->total_grand = CartManagement::getGrandTotal($this->cart_items);
    }

    public function decreaseQty($product_id) {
        $this->cart_items = CartManagement::decrementItemQuantityInCartItem($product_id);
        $this->total_grand = CartManagement::getGrandTotal($this->cart_items);
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
