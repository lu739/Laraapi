<?php

namespace App\Models;

use App\Enum\ProductStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'count',
        'status',
    ];

    protected $casts = [
        'status' => ProductStatus::class,
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function reviews() {
        return $this->hasMany(ProductReview::class);
    }

    public function images() {
        return $this->hasMany(ProductImage::class)->select('path');
    }

    public function rating() {
        return round($this->reviews()->avg('rating'), 1);
    }

    public function isDraft() {
        return $this->status === ProductStatus::DRAFT;
    }
}
