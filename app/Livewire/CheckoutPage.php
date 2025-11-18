<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Check out")]
class CheckoutPage extends Component
{
    public $first_name;
    public $last_name;
    public $phone;
    public $street_address;
    public $city;
    public $state;
    public $zip_code;
    public $payment_method;


    public function placeOrder() {
        $this->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'phone' => ['required', 'int', 'max:50'],
            'street_address' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'zip_code' => ['required', 'max:10'],
            'payment_method' => ['required'],
        ]);
    }

    public function render()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();
        $grand_total = CartManagement::getGrandTotal($cart_items);
        return view('livewire.checkout-page', [
            'cart_items' => $cart_items, 
            'grand_total' => $grand_total
        ]);
    }
}
