<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MakananModel extends Model
{
    use HasFactory;
    protected $table = "makanan";
    protected $primaryKey = "id_makanan";

    public function cari($keywords){
        return DB::table($this->table)
        ->where('name','like',"%$keywords%")
        ->get();
    }

}
