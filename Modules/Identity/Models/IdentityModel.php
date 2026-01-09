<?php
namespace Modules\Identity\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IdentityModel extends Model {
    use HasFactory;
    protected $table = 'identitys';
    protected $fillable = ['name'];
}
