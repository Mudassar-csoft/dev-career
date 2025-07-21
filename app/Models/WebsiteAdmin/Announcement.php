<?php

namespace App\Models\WebsiteAdmin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $dates = ['publish_date', 'valid_date'];

    protected $filable = [
        'title',
        'image',
        'publish_date',
        'valid_date',
        'description',
    ];
}
