<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
	use SoftDeletes;
	
	protected $table = 'todos';
	
    protected $fillable = [
    	'user_id',
	    'todo',
	    'complete_status',
	    'completed_at'
    ];
    
    public function user(){
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
