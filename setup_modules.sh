#!/bin/bash

echo "Đang khởi tạo Business Modules (Kèm Repositories & Binding)..."

# Danh sách Module
MODULES=("Tour" "Booking" "Partner" "Identity" "Payment" "Hotel" "Visa")

for MODULE in "${MODULES[@]}"; do
    echo "Creating module: $MODULE"
    
    BASE_PATH="Modules/$MODULE"
    
    # 1. Tạo cấu trúc thư mục (Đầy đủ Repositories)
    mkdir -p "$BASE_PATH/Config"
    mkdir -p "$BASE_PATH/Console"
    mkdir -p "$BASE_PATH/Database/Migrations"
    mkdir -p "$BASE_PATH/Database/Seeders"
    mkdir -p "$BASE_PATH/DTO"
    mkdir -p "$BASE_PATH/Entities"
    mkdir -p "$BASE_PATH/Enums"
    mkdir -p "$BASE_PATH/Http/Controllers"
    mkdir -p "$BASE_PATH/Http/Requests"
    mkdir -p "$BASE_PATH/Http/Middleware"
    mkdir -p "$BASE_PATH/Interfaces"         # Định nghĩa Interface
    mkdir -p "$BASE_PATH/Repositories"       # <--- MỚI: Nơi Implement Interface
    mkdir -p "$BASE_PATH/Models"
    mkdir -p "$BASE_PATH/Providers"
    mkdir -p "$BASE_PATH/Routes"
    mkdir -p "$BASE_PATH/Services"
    mkdir -p "$BASE_PATH/Support/Traits"
    mkdir -p "$BASE_PATH/UseCases"

    # 2. Tạo Model trước (để Repo gọi)
    cat <<EOT > "$BASE_PATH/Models/${MODULE}Model.php"
<?php
namespace Modules\\$MODULE\\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ${MODULE}Model extends Model {
    use HasFactory;
    protected \$table = '$(echo $MODULE | tr '[:upper:]' '[:lower:]')s';
    protected \$fillable = ['name'];
}
EOT

    # 3. Tạo Interface (Hợp đồng)
    cat <<EOT > "$BASE_PATH/Interfaces/${MODULE}RepositoryInterface.php"
<?php

namespace Modules\\$MODULE\\Interfaces;

interface ${MODULE}RepositoryInterface
{
    public function getAll();
    public function findById(int \$id);
    public function create(array \$data);
}
EOT

    # 4. Tạo Repository (Người thực thi hợp đồng)
    cat <<EOT > "$BASE_PATH/Repositories/${MODULE}Repository.php"
<?php

namespace Modules\\$MODULE\\Repositories;

use Modules\\$MODULE\\Interfaces\\${MODULE}RepositoryInterface;
use Modules\\$MODULE\\Models\\${MODULE}Model;

class ${MODULE}Repository implements ${MODULE}RepositoryInterface
{
    public function getAll()
    {
        return ${MODULE}Model::all();
    }

    public function findById(int \$id)
    {
        return ${MODULE}Model::findOrFail(\$id);
    }

    public function create(array \$data)
    {
        return ${MODULE}Model::create(\$data);
    }
}
EOT

    # 5. Service (Gọi Repository qua Interface, không gọi trực tiếp Class)
    cat <<EOT > "$BASE_PATH/Services/${MODULE}Service.php"
<?php

namespace Modules\\$MODULE\\Services;

use Modules\\$MODULE\\Interfaces\\${MODULE}RepositoryInterface;

class ${MODULE}Service
{
    public function __construct(
        protected ${MODULE}RepositoryInterface \$repository
    ) {}

    public function getList()
    {
        return \$this->repository->getAll();
    }
}
EOT

    # 6. ServiceProvider (QUAN TRỌNG: Bind Interface -> Repo)
    cat <<EOT > "$BASE_PATH/Providers/${MODULE}ServiceProvider.php"
<?php

namespace Modules\\$MODULE\\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Modules\\$MODULE\\Interfaces\\${MODULE}RepositoryInterface;
use Modules\\$MODULE\\Repositories\\${MODULE}Repository;

class ${MODULE}ServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind Interface vào Implementation
        // Khi ai đó xin Interface, Laravel sẽ trả về Repository cụ thể
        \$this->app->bind(
            ${MODULE}RepositoryInterface::class,
            ${MODULE}Repository::class
        );
    }

    public function boot(): void
    {
        \$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::prefix('api/v1/$(echo $MODULE | tr '[:upper:]' '[:lower:]')s')
            ->middleware('api')
            ->group(__DIR__ . '/../Routes/api.php');
    }
}
EOT

    # 7. Route & Controller
    cat <<EOT > "$BASE_PATH/Routes/api.php"
<?php
use Illuminate\Support\Facades\Route;
Route::get('/', function() { return ['status' => 'ok']; });
EOT

done

echo "Hoàn tất! Đã tạo đầy đủ Interface, Repository và Binding."