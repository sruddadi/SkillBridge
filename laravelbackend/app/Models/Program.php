<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'programs';
    public $timestamps = false;
    protected $fillable = ['programName', 'programOrganizer', 'programDescription', 'startDate', 'endDate', 'venue'];
}
