<?php
namespace Modules\Booking\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingModel extends Model {
    use HasFactory;
    protected $table = 'bookings';
    protected $fillable = ['name'];
}
