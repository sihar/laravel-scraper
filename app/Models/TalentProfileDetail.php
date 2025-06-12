<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TalentProfileDetail extends Model
{
    use SoftDeletes;
    protected $table = 'talent_profiles_details';
}
