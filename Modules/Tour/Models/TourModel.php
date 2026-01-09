<?php
namespace Modules\Tour\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TourModel extends Model {
    use HasFactory;
    protected $table = 'tours';
    protected $fillable = ['name'];
}
