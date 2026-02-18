<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'label',
    ];

    protected $dates = ['deleted_at'];

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
