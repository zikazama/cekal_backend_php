<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasModel extends Model
{
    use HasFactory;
    protected $table = "aktivitas";
    protected $primaryKey = "id_aktivitas";
}
