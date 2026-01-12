#!/bin/bash

echo "🚀 Đang khởi tạo hệ thống Super App (Shared tối giản + 5 Modules chuẩn)..."

# Danh sách Modules nghiệp vụ
# Travel: Tour, Hotel (Kho hàng)
# Flight: Vé máy bay (API)
# Concierge: Visa, Xe, Sự kiện (Form Request)
BUSINESS_MODULES=("Travel" "Flight" "Concierge")

# ==============================================================================
# 1. MODULE SHARED (TỐI GIẢN - CHỈ CHỨA CORE)
# ==============================================================================
echo "🛠  Module: Shared (Core only)..."
BASE_SHARED="Modules/Shared"

# Chỉ tạo những thư mục thực sự cần thiết dùng chung
mkdir -p "$BASE_SHARED/DTO"
mkdir -p "$BASE_SHARED/Repositories"
mkdir -p "$BASE_SHARED/Contracts"
mkdir -p "$BASE_SHARED/Support/Traits"
mkdir -p "$BASE_SHARED/Providers"

# 1.1 BaseDTO (Dùng Spatie Data)
cat <<EOT > "$BASE_SHARED/DTO/BaseDTO.php"
<?php
namespace Modules\\Shared\\DTO;
use Spatie\\LaravelData\\Data;

abstract class BaseDTO extends Data {
    // Cấu hình chung cho toàn bộ DTO của hệ thống (VD: Map naming strategy)
}
EOT

# 1.2 BaseRepository (Logic CRUD Eloquent chung)
cat <<EOT > "$BASE_SHARED/Repositories/BaseRepository.php"
<?php
namespace Modules\\Shared\\Repositories;

abstract class BaseRepository {
    // Các hàm create(), update(), find() viết ở đây để tái sử dụng
}
EOT

# 1.3 SharedServiceProvider (Chỉ để load Helper hoặc Migration chung nếu có)
cat <<EOT > "$BASE_SHARED/Providers/SharedServiceProvider.php"
<?php
namespace Modules\\Shared\\Providers;
use Illuminate\Support\ServiceProvider;

class SharedServiceProvider extends ServiceProvider {
    public function boot(): void {
        // Load migrations chung (nếu có, ví dụ bảng logs)
        // \$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
EOT


# ==============================================================================
# 2. MODULE IDENTITY (QUẢN LÝ 3 LOẠI USER)
# ==============================================================================
echo "🛡  Module: Identity (Multi-Auth)..."
BASE_AUTH="Modules/Identity"
mkdir -p "$BASE_AUTH/Models" "$BASE_AUTH/DTO" "$BASE_AUTH/Providers" "$BASE_AUTH/Routes"
mkdir -p "$BASE_AUTH/Services" "$BASE_AUTH/Contracts" "$BASE_AUTH/Repositories"
mkdir -p "$BASE_AUTH/Http/Controllers" "$BASE_AUTH/Database/Migrations"

# 2.1 Ba Model riêng biệt
cat <<EOT > "$BASE_AUTH/Models/Admin.php"
<?php
namespace Modules\\Identity\\Models;
use Illuminate\\Foundation\\Auth\\User as Authenticatable;
use Laravel\\Sanctum\\HasApiTokens;
use Spatie\\Permission\\Traits\\HasRoles;
class Admin extends Authenticatable {
    use HasApiTokens, HasRoles;
    protected \$guard_name = 'admin';
    protected \$guarded = [];
}
EOT

cat <<EOT > "$BASE_AUTH/Models/Partner.php"
<?php
namespace Modules\\Identity\\Models;
use Illuminate\\Foundation\\Auth\\User as Authenticatable;
use Laravel\\Sanctum\\HasApiTokens;
class Partner extends Authenticatable {
    use HasApiTokens;
    protected \$guarded = [];
}
EOT

cat <<EOT > "$BASE_AUTH/Models/User.php"
<?php
namespace Modules\\Identity\\Models;
use Illuminate\\Foundation\\Auth\\User as Authenticatable;
use Laravel\\Sanctum\\HasApiTokens;
class User extends Authenticatable {
    use HasApiTokens;
    protected \$guarded = [];
}
EOT

# 2.2 LoginDTO
cat <<EOT > "$BASE_AUTH/DTO/LoginDTO.php"
<?php
namespace Modules\\Identity\\DTO;
use Modules\\Shared\\DTO\\BaseDTO;
class LoginDTO extends BaseDTO {
    public function __construct(public string \$email, public string \$password, public string \$type) {}
}
EOT

# 2.3 Provider & Route
cat <<EOT > "$BASE_AUTH/Providers/IdentityServiceProvider.php"
<?php
namespace Modules\\Identity\\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
class IdentityServiceProvider extends ServiceProvider {
    public function boot(): void {
        \$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::prefix('api/v1/auth')->middleware('api')->group(__DIR__ . '/../Routes/api.php');
    }
}
EOT
echo "<?php use Illuminate\Support\Facades\Route; Route::post('login', function(){ return 'Login API'; });" > "$BASE_AUTH/Routes/api.php"


# ==============================================================================
# 3. BUSINESS MODULES (Travel, Flight, Concierge)
# ==============================================================================
for MODULE in "${BUSINESS_MODULES[@]}"; do
    echo "💼 Module: $MODULE..."
    BASE_PATH="Modules/$MODULE"

    # Cấu trúc chuẩn
    mkdir -p "$BASE_PATH/Config" "$BASE_PATH/Database/Migrations" "$BASE_PATH/DTO"
    mkdir -p "$BASE_PATH/Models" "$BASE_PATH/Services" "$BASE_PATH/Contracts"
    mkdir -p "$BASE_PATH/Repositories" "$BASE_PATH/Providers" "$BASE_PATH/Routes"

    # Chia Controller theo đối tượng gọi
    mkdir -p "$BASE_PATH/Http/Controllers/Admin"
    mkdir -p "$BASE_PATH/Http/Controllers/Partner"
    mkdir -p "$BASE_PATH/Http/Controllers/Public"

    # --- TẠO LOGIC RIÊNG CHO TỪNG MODULE ---
    if [ "$MODULE" == "Concierge" ]; then
        # Concierge: Chuyên xử lý Request (Visa, Xe, Sự kiện)
        cat <<EOT > "$BASE_PATH/Models/VisaRequest.php"
<?php
namespace Modules\\$MODULE\\Models;
use Illuminate\Database\Eloquent\Model;
class VisaRequest extends Model { protected \$guarded = []; }
EOT
        cat <<EOT > "$BASE_PATH/Models/CarRequest.php"
<?php
namespace Modules\\$MODULE\\Models;
use Illuminate\Database\Eloquent\Model;
class CarRequest extends Model { protected \$guarded = []; }
EOT
        cat <<EOT > "$BASE_PATH/Models/EventRequest.php"
<?php
namespace Modules\\$MODULE\\Models;
use Illuminate\Database\Eloquent\Model;
class EventRequest extends Model { protected \$guarded = []; }
EOT
        # DTO mẫu
        cat <<EOT > "$BASE_PATH/DTO/CreateRequestDTO.php"
<?php
namespace Modules\\$MODULE\\DTO;
use Modules\\Shared\\DTO\\BaseDTO;
class CreateRequestDTO extends BaseDTO {
    public function __construct(public string \$customer_name, public string \$service_type) {}
}
EOT

    elif [ "$MODULE" == "Travel" ]; then
        # Travel: Chuyên xử lý Sản phẩm (Tour, Hotel)
        cat <<EOT > "$BASE_PATH/Models/Tour.php"
<?php
namespace Modules\\$MODULE\\Models;
use Illuminate\Database\Eloquent\Model;
use Modules\Identity\Models\Partner; // Ví dụ link sang Partner
class Tour extends Model { protected \$guarded = []; }
EOT
        cat <<EOT > "$BASE_PATH/Models/Hotel.php"
<?php
namespace Modules\\$MODULE\\Models;
use Illuminate\Database\Eloquent\Model;
class Hotel extends Model { protected \$guarded = []; }
EOT
        # DTO mẫu
        cat <<EOT > "$BASE_PATH/DTO/TourDTO.php"
<?php
namespace Modules\\$MODULE\\DTO;
use Modules\\Shared\\DTO\\BaseDTO;
class TourDTO extends BaseDTO {
    public function __construct(public string \$title, public float \$price) {}
}
EOT

    else
        # Flight: Vé máy bay
        cat <<EOT > "$BASE_PATH/Models/FlightOrder.php"
<?php
namespace Modules\\$MODULE\\Models;
use Illuminate\Database\Eloquent\Model;
class FlightOrder extends Model { protected \$guarded = []; }
EOT
        # DTO mẫu
        cat <<EOT > "$BASE_PATH/DTO/SearchFlightDTO.php"
<?php
namespace Modules\\$MODULE\\DTO;
use Modules\\Shared\\DTO\\BaseDTO;
class SearchFlightDTO extends BaseDTO {
    public function __construct(public string \$from_code, public string \$to_code) {}
}
EOT
    fi

    # --- TẠO FILE DÙNG CHUNG CHO CÁC MODULE ---

    # Contract
    cat <<EOT > "$BASE_PATH/Contracts/${MODULE}RepositoryContract.php"
<?php
namespace Modules\\$MODULE\\Contracts;
interface ${MODULE}RepositoryContract {
    public function getAll();
}
EOT

    # Repository
    cat <<EOT > "$BASE_PATH/Repositories/${MODULE}Repository.php"
<?php
namespace Modules\\$MODULE\\Repositories;
use Modules\\Shared\\Repositories\\BaseRepository;
use Modules\\$MODULE\\Contracts\\${MODULE}RepositoryContract;

class ${MODULE}Repository extends BaseRepository implements ${MODULE}RepositoryContract {
    public function getAll() { return []; }
}
EOT

    # Service
    cat <<EOT > "$BASE_PATH/Services/${MODULE}Service.php"
<?php
namespace Modules\\$MODULE\\Services;
use Modules\\$MODULE\\Contracts\\${MODULE}RepositoryContract;

class ${MODULE}Service {
    public function __construct(protected ${MODULE}RepositoryContract \$repo) {}
}
EOT

    # Controller Admin Mẫu
    cat <<EOT > "$BASE_PATH/Http/Controllers/Admin/${MODULE}Controller.php"
<?php
namespace Modules\\$MODULE\\Http\\Controllers\\Admin;
use App\\Http\\Controllers\\Controller;
use Modules\\$MODULE\\Services\\${MODULE}Service;

class ${MODULE}Controller extends Controller {
    public function __construct(protected ${MODULE}Service \$service) {}
    public function index() { return response()->json(['message' => 'Hello Admin $MODULE']); }
}
EOT

    # Provider
    cat <<EOT > "$BASE_PATH/Providers/${MODULE}ServiceProvider.php"
<?php
namespace Modules\\$MODULE\\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\\$MODULE\\Contracts\\${MODULE}RepositoryContract;
use Modules\\$MODULE\\Repositories\\${MODULE}Repository;

class ${MODULE}ServiceProvider extends ServiceProvider {
    public function register(): void {
        \$this->app->bind(${MODULE}RepositoryContract::class, ${MODULE}Repository::class);
    }
    public function boot(): void {
        \$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::prefix('api/v1/admin/$(echo $MODULE | tr '[:upper:]' '[:lower:]')')
            ->middleware(['api', 'auth:admin'])
            ->group(__DIR__ . '/../Routes/admin.php');
    }
}
EOT
    echo "<?php use Illuminate\Support\Facades\Route; use Modules\\$MODULE\\Http\\Controllers\\Admin\\${MODULE}Controller; Route::get('/', [${MODULE}Controller::class, 'index']);" > "$BASE_PATH/Routes/admin.php"

done

echo "✅ ĐÃ XONG! Cấu trúc tối ưu: Shared gọn nhẹ + 5 Modules nghiệp vụ."
