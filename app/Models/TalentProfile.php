<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TalentProfile extends Model
{
    use SoftDeletes;
    protected $table = 'talent_profiles';
}
