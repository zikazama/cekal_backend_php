<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukalModel extends Model
{
    use HasFactory;
    protected $table = "bukal";
    protected $primaryKey = "id_bukal";
}
