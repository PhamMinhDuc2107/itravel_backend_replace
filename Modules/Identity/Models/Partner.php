<?php
namespace Modules\Identity\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
class Partner extends Authenticatable {
    use HasApiTokens;
    protected $guarded = [];
}
