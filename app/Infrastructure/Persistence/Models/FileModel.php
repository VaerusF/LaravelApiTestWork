<?php

namespace App\Infrastructure\Persistence\Models;

use App\Core\Domain\Enums\FileTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileModel extends Model
{
    use HasFactory;

    protected $table = 'files';
    protected $primaryKey = 'file_id';
    protected $fillable = ['file_type', 'file_name'];

    public $casts = [
        'file_type' => FileTypes::class,
    ];

    public $timestamps = false;
}
