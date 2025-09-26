<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class PanelProduct extends Product
{
    protected static function booted() {
        // Remover el scope global
    }
}
