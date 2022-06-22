<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Report
 * @package App\Models
 * @property string $currency
 * @property int $status_id
 * @property Carbon $created_at
 * @property string $data
 */
class Report extends Model
{
    protected $appends = ['status', 'name'];

    public const REPORT_STATUSES = [
      'pending' => 1,
      'completed' => 2
    ];

    public const REPORT_TYPES = [
        1 => [
            'label' => 'One Year - Interval - Monthly',
        ],
        2 => [
            'label' => 'Six Months - Interval - Weekly',
        ],
        3 => [
            'label' => 'One Month - Interval - Daily',
        ],
    ];

    protected $fillable = [
      'type',
      'currency',
      'user_id',
      'status_id',
        'data'
    ];

    public function user():HasOne
    {
        return $this->hasOne(User::class);
    }


    /**
     * @param Builder $query
     * @param int $stats_id
     * @return Builder
     */
    public function scopeOfStatus(Builder $query, $stats_id)
    {
        return $query->where('status_id', $stats_id);

    }

    // appended status as a string
    public function getStatusAttribute() : string
    {
        return array_flip(self::REPORT_STATUSES)[$this->status_id];
    }

    // appended status as a string
    public function getNameAttribute() : string
    {
        return self::REPORT_TYPES[$this->status_id]['label'];
    }


}
