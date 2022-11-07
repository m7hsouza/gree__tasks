<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $hidden = ['updated_at', 'user_id', 'stage_id'];

    protected $attributes = [
        'stage_id' => 1,
        'progress' => 0,
    ];

    protected $with = [
        'assignee:id,name,img',
        'stage'
    ];


    public function assignee()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function stage()
    {
        return $this->belongsTo('App\TaskStages', 'stage_id');
    }

    protected $appends = ['formatted_created_at'];
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d-m-Y');
    }
}
