<?php
namespace Amirabbas8643\Todo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Label extends Model
{
    protected $fillable = [
        'label',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * Each task have many labels
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class , 'task_has_labels');
    }
}
