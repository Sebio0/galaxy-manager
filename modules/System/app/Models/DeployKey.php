<?php

namespace Modules\System\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DeployKey extends Model
{
    use HasUlids;

    /**
     * @return BelongsToMany<GameInstance, $this>
     */
    public function gameInstances(): BelongsToMany
    {
        return $this->belongsToMany(GameInstance::class);
    }
}
