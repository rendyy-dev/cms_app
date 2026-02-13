<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'label',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function isDefault()
    {
        return in_array($this->name, [
            'super_admin',
            'admin',
            'editor',
            'author',
            'user',
        ]);
    }

}
