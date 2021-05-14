<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    const ROLE_EDITORIAL_DESIGN_MANAGER = 'editorial design manager';
    const ROLE_CEO = 'ceo';
    const ROLE_EDITORIAL_DIRECTOR = 'editorial director';
    const ROLE_EDITORIAL_RESPONSIBLE = 'editorial responsible';
    const ROLE_SALES_DIRECTOR = 'sales director';
    const ROLE_ADMIN = 'admin';


    protected $table = 'roles';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_role');
    }


}
