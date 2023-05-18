<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationOfImage extends Model
{
    use HasFactory;
    protected $table = 'registration_of_images';

    protected $fillable = ['name', 'folder', 'url'];

    protected $dates = ['removed_at'];
}
