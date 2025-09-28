<?php

declare(strict_types = 1);

namespace App\Models;

use App\Enum\PriorityEnum;
use App\Enum\StatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|null $id
 * @property string $title
 * @property string $description
 * @property StatusEnum $status
 * @property PriorityEnum $priority
 * @property Carbon $due_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property mixed $dueDate
 */
class Task extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'title',
        'description',
        'status',
        'priority',
        'dueDate',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'status' => StatusEnum::class,
        'priority' => PriorityEnum::class,
    ];

    protected $dates = [
        'dueDate',
        'created_at',
        'updated_at',
    ];
}
