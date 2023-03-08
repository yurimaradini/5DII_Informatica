<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
//use App\Models\Like;
use App\Models\Comment;

class Like extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function news()
    {
    	return $this->belongsTo(News::class);
	}

	public function user()
    {
    	return $this->belongsTo(User::class);
	}

    public function comment()
    {
    	return $this->belongsTo(Comment::class);
	}
}