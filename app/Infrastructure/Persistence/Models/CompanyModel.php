<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyModel extends Model
{
    use HasFactory;

    protected $table = 'company';
    protected $primaryKey = 'company_id';
    protected $fillable = ['company_name', 'description'];

    public function Logo(): BelongsTo
    {
        return $this->belongsTo(FileModel::class, 'logo_id');
    }

    public $timestamps = false;
}
