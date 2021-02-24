<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kata extends Model
{
    use HasFactory;
    
    protected $table='tb_katadasar';
    protected $primaryKey='id';
    protected $fillable=['katadasar','tipe_katadasar'];

}
