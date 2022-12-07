<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;
    protected $casts = [
        'textAttribs' => 'array',
        'templateSize' => 'array',
        'dataFileAttribs' => 'array',
    ];
    protected $fillable = [
        'user',
        'project_name',
        'template',
        'templateSize',
        'textAttribs',
        'datasrc',
        'dataFileAttribs',
    ];
}
