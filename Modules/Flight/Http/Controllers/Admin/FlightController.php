<?php
namespace Modules\Flight\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Modules\Flight\Services\FlightService;

class FlightController extends Controller {
    public function __construct(protected FlightService $service) {}
    public function index() { return response()->json(['message' => 'Hello Admin Flight']); }
}
