<?php
declare(strict_types=1);

namespace App\Models\Product;

use MongoDB\Laravel\Eloquent\HybridRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsToMany;


class Order extends Model
{
    use HasFactory, HybridRelations;

    protected $connection = 'mongodb';
    protected $collection = 'orders';

    protected $fillable = [
        'count',
        'total_price',
    ];


    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, null, 'orders_ids', 'products_ids');
    }

}
