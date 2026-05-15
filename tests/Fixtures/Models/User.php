<?php

namespace Hemil09\TypeGen\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use Hemil09\TypeGen\Attributes\TypeScript;

#[TypeScript]
class User extends Model
{
    protected $fillable = ['name', 'email', 'role'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'preferences' => 'array',
    ];
}
