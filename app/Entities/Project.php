<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  protected $fillable = [
    'name',
    'description',
    'progress',
    'status',
    'due_date'
  ];

  public function user()
    {
        return $this->belongsTo('CodeProject\Entities\User');
    }

  public function client()
    {
        return $this->belongsTo('CodeProject\Entities\Client');
    }
}
