<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;
    CONST ROLE_EDITORIAL_DESIGN_MANAGER = 'editorial design manager';


    protected $table = 'roles';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'user_role');
    }


}
