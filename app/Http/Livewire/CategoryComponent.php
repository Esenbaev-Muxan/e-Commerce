<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;

class CategoryComponent extends Component
{
    use WithPagination;
    public $pageSize = 12;
    public $orderBy = "Default Sorting";
    public $slug;
    public function store($product_id,$product_name,$product_price)
    {
        Cart::add($product_id,$product_name,1,$product_price)->associate('\App\Models\Product');
        session()->flash('success_message','Item added in Cart');
        return redirect()->route('shop.cart');
    }

    public function chengePagesize($size)
    {
        $this->pageSize = $size;
    }

    public function changeOrderBy($order)
    {
        $this->orderBy = $order;
    }

    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function render()
    {
        $category = Category::where('slug',$this->slug)->first();
        $category_id = $category->id;
        $category_name = $category->name;

        if($this->orderBy == 'Price: Low to High')
        {
            $products = Product::where('category_id',$category_id)->orderBy('regular_price','ASC')->paginate($this->pageSize);
        }
        else if($this->orderBy == 'Price: High to Low')
        {
            $products = Product::where('category_id',$category_id)->orderBy('regular_price','DESC')->paginate($this->pageSize);
        }
        else if($this->orderBy == 'Sort By Newess')
        {
            $products = Product::where('category_id',$category_id)->orderBy('created_at','DESC')->paginate($this->pageSize);
        }
        else 
        {
            $products = Product::where('category_id',$category_id)->paginate($this->pageSize);
        }
        $categories = Category::orderBy('name','ASC')->get();
        
        return view('livewire.category-component',['products'=>$products, 'categories'=>$categories,'category_name'=>$category_name]);
    }


    // public function addToCart($product_id)
    // {
    //     $product = Product::find($product_id);
    
    //     if (!$product->price || !is_numeric($product->price)) {
    //         // If the product price is not set or is not numeric, set a default price
    //         $product_price = 0;
    //     } else {
    //         $product_price = $product->price;
    //     }
    
    //     $product_name = $product->name;
    
    //     Cart::add($product_id, $product_name, 1, $product_price)->associate('\App\Models\Product');
    //     session()->flash('success_message', 'Item added in Cart');
    
    //     return $this->render();
    // }
    
    // public function render()
    // {
    //     $products = Product::paginate(12);
    //     return view('livewire.shop-component', ['products' => $products]);
    // }


    

}