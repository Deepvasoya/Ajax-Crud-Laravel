<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userinformation extends Model
{
    use HasFactory;

    protected $table = 'userinformations';

    protected $fillable = [
        'name',
        'email',
        'Designation',
    ];
}
