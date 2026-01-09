<?php
namespace Modules\Payment\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentModel extends Model {
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = ['name'];
}
