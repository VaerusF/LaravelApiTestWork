<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = ['firstname', 'lastname', 'phone'];

    public function Avatar(): BelongsTo
    {
        return $this->belongsTo(FileModel::class, 'avatar_id');
    }

    public $timestamps = false;
}
