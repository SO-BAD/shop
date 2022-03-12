<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class ManagerLoginTokens extends Model
{
    use HasFactory;


    protected $table= 'managerLoginTokens';
    // 關閉laravel預設時間戳記
    public $timestamps = false;


}
