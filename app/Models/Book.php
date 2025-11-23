<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // ✅ important

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['title','author','isbn','publisher','published_at','summary'];

    public function meta()
    {
        return $this->hasMany(BookMeta::class);
    }
}
