<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Campaign
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $template
 * @property array|null $segmentation_criteria
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $scheduled_at
 * @property \Illuminate\Support\Carbon|null $sent_at
 * @property int $recipient_count
 * @property int $delivered_count
 * @property int $opened_count
 * @property int $clicked_count
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $creator
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign query()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereClickedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereDeliveredCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereOpenedCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereRecipientCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereSegmentationCriteria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereUpdatedAt($value)
 * @method static \Database\Factories\CampaignFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Campaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'type',
        'template',
        'segmentation_criteria',
        'status',
        'scheduled_at',
        'sent_at',
        'recipient_count',
        'delivered_count',
        'opened_count',
        'clicked_count',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'segmentation_criteria' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'recipient_count' => 'integer',
        'delivered_count' => 'integer',
        'opened_count' => 'integer',
        'clicked_count' => 'integer',
    ];

    /**
     * Get the creator of this campaign.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}