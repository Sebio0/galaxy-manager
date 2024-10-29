<?php

namespace Modules\System\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameInstanceUrl extends Model
{
    use HasUlids;

    /**
     * @return BelongsTo<GameInstance, $this>
     */
    public function gameInstance(): BelongsTo
    {
        return $this->belongsTo(GameInstance::class);
    }

    /**
     * @return HasMany<GameInstanceUrl, $this>
     */
    public function instanceUrls(): HasMany
    {
        return $this->hasMany(GameInstanceUrl::class);
    }
}
