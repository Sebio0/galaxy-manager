<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GameInstance extends Model
{
    use HasUlids;

    /**
     * @return HasOne<DeployKey, $this>
     */
    public function deployKey(): HasOne
    {
        return $this->hasOne(DeployKey::class);
    }

    /**
     * @return HasMany<GameInstanceUrl, $this>
     */
    public function instanceUrls(): HasMany
    {
        return $this->hasMany(GameInstanceUrl::class);
    }
}
