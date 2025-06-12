<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TalentProfile extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'talent_profiles';

    protected $fillable = [
        'url',
        'username',
        'name',
        'job_position',
        'summary_experience',
    ];
}
