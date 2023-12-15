<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramEnroll extends Model
{
    protected $table = 'programEnroll'; // Set the table name

    protected $fillable = [
        'sname',
        'semail',
        'programName',
        'pOrganizer',
        'pDescription',
        'startDate',
        'endDate',
        'venue'
    ];
    public $timestamps = false;
}
