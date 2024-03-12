<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',

    ];

    /*
    Relacion uno a muchos inversa
    */
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }

    /**
     * Realcion uno a muchos
     */

    public function comments(): HasMany{
        return $this->hasMany(Comment::class);
    }

    /**
     * Relacion muchos a muchos inversa
     */

     public function tags(): BelongsToMany{
        return $this->belongsToMany(Tag::class);
     }


     /** */
     public function images(){
        return $this->morphMany(Image::class, 'imageable');
     }

}
