<?php
namespace Modules\Visa\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisaModel extends Model {
    use HasFactory;
    protected $table = 'visas';
    protected $fillable = ['name'];
}
