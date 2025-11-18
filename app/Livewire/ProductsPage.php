<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\Enums\Position;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;


#[Title('Products - MadeByOmar')]
class ProductsPage extends Component
{

    #[Url()]
    public $selected_categories = []; 

    #[Url()]
    public $selected_brands = []; 

    #[Url()]
    public $featured; 

    #[Url()]
    public $sale;

    #[Url()]
    public $sort = 'latest';

    public $price_range = 5000;

    // Add to cart method 

    public function addToCart($product_id) {
        $total_count = CartManagement::addItemToCart($product_id); 

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        
        LivewireAlert::title('Success!')
            ->text('Product Added To Cart Successfully')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }
    
    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);

        if(!empty($this->selected_categories)) {
            $productQuery->whereIn('category_id', $this->selected_categories);
        }

        if(!empty($this->selected_brands)) {
            $productQuery->whereIn('brand_id', $this->selected_brands);
        }
        if($this->featured) {
            $productQuery->where('is_featured', 1);
        }
        if($this->sale) {
            $productQuery->where('on_sale', 1);
        }

        if($this->price_range) {
            $productQuery->whereBetween('price', [0, $this->price_range]);
        }

        if($this->sort == 'latest') {
            $productQuery->latest();
        }elseif($this->sort == 'price') {
            $productQuery->orderBy('price', 'desc');
        }

        $brands = Brand::where('is_active', 1)->get(['id', 'name', 'slug']);
        $categories = Category::where('is_active', 1)->get(['id', 'name', 'slug']);
        return view('livewire.products-page', [
            'products' => $productQuery->paginate(9), 
            'brands' => $brands,
            'categories' => $categories
        ]);
    }
}
