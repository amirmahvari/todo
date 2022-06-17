<?php
namespace Amirmahvari\Todo\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    protected $fillable = [
        'title' ,
        'description' ,
        'status' ,
        'user_id' ,
        'status' ,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * Each task belongs to one user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * Each task have many labels
     */
    public function labels():BelongsToMany
    {
        return $this->belongsToMany(Label::class,'task_has_labels');
    }
}
