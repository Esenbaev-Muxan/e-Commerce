<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;

class WithlistComponent extends Component
{
    public function removeFromWishlist($product_id, )
    {
        foreach(Cart::instance('wishlist')->content() as $witem)
        {
            if($witem->id==$product_id)
            {
                Cart::instance('wishlist')->remove($witem->rowId);
                $this->emitTo('withlist-icon-component','refreshComponent');
                return;
            }
        }
    }
    public function render()
    {
        return view('livewire.withlist-component');
    }
}
