<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator
{

  protected $rules = [
    'name' => 'required|max:255',
    'description' => 'required',
    'status' => 'required|max:255',
    'progress' => 'required|max:255',
    'due_date' => 'required'
  ];

}
