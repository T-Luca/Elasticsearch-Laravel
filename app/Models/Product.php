<?php

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

class Product extends Eloquent
{
    const ELASTIC_INDEX = 'products';
    const ELASTIC_TYPE  = 'product';


	protected $fillable = [
		'title',
		'description',
        'imagePath',
        'stock',
        'price',
        'category_id'
	];

}
