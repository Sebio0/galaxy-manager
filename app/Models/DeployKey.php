<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use phpDocumentor\Reflection\Types\This;

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
