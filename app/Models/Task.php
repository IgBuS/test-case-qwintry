<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'completed'
    ];

    /**
     * The status that belong to the task.
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
