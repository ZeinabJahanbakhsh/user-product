<?php
declare(strict_types=1);

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsToMany;
use MongoDB\Laravel\Relations\EmbedsMany;
use MongoDB\Laravel\Eloquent\HybridRelations;


class Product extends Model
{
    use HasFactory;
    use HybridRelations;


    protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $fillable = [
        'name',
        'price',
        'inventory'
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, null, 'products_ids', 'orders_ids');
    }

}
