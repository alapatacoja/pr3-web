<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
protected $fillable = ['name', 'category', 'price', 'available', 'image_path', 'flexsim_shape', 'flexsim_spot', 'id_item'];}
