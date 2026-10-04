<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class WholesaleAccessCode extends Model
{
    protected $fillable = ['customer_name', 'code_hash', 'code_hint', 'is_active', 'expires_at', 'last_used_at'];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
    ];

    public function isValid(): bool
    {
        return $this->is_active && (!$this->expires_at || $this->expires_at->isFuture());
    }

    public function matches(string $plainCode): bool
    {
        return $this->isValid() && Hash::check($plainCode, $this->code_hash);
    }
}
