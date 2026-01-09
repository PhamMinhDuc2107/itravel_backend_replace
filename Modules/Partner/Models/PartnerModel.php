<?php
namespace Modules\Partner\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PartnerModel extends Model {
    use HasFactory;
    protected $table = 'partners';
    protected $fillable = ['name'];
}
