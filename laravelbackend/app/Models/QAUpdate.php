<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QAUpdate extends Model
{
    protected $table = 'qAUpdates';
    protected $fillable = ['qaPolicies', 'year', 'policyId'];
    public $timestamps = false; // Add this if your table doesn't have created_at and updated_at columns
}
