<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Org extends Model
{
    use HasFactory;

    protected $table = 'orgs';
    protected $fillable = ['title', 'org_no'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
