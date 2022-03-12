<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Manager extends Model
{
    use HasFactory;


    protected $table= 'managers';
    // 關閉laravel預設時間戳記
    public $timestamps = false;


}
