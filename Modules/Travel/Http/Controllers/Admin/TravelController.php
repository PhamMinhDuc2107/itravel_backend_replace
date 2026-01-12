<?php
namespace Modules\Travel\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Modules\Travel\Services\TravelService;

class TravelController extends Controller {
    public function __construct(protected TravelService $service) {}
    public function index() { return response()->json(['message' => 'Hello Admin Travel']); }
}
