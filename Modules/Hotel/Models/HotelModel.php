<?php
namespace Modules\Hotel\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HotelModel extends Model {
    use HasFactory;
    protected $table = 'hotels';
    protected $fillable = ['name'];
}
