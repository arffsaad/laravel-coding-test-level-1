<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidTrait;

class Event extends Model
{
    use HasFactory, UuidTrait, SoftDeletes;

    // Constants
    const DELETED_AT = 'deletedAt';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    // Create UUID on creation
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->UuidTrait();
    }

    protected $fillable = [
        'name',
        'slug',
        'createdAt',
        'updatedAt',
        'startAt',
        'endAt'
    ];

}
