<?php
namespace Modules\Concierge\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Modules\Concierge\Services\ConciergeService;

class ConciergeController extends Controller {
    public function __construct(protected ConciergeService $service) {}
    public function index() { return response()->json(['message' => 'Hello Admin Concierge']); }
}
