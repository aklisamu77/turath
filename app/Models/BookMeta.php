<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // ✅ important

class BookMeta extends Model
{
    use HasFactory;
    protected $table = 'book_meta';

    protected $fillable = ['book_id','meta_key','meta_value'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
