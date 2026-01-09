#!/bin/bash

echo "Đang chuẩn hóa lại Module Shared (Base Architecture)..."

# 1. Xóa cũ làm lại cho sạch
rm -rf Modules/Shared

BASE_PATH="Modules/Shared"

# 2. Tạo cấu trúc thư mục chuẩn
mkdir -p "$BASE_PATH/Config"
mkdir -p "$BASE_PATH/Enums"
mkdir -p "$BASE_PATH/Interfaces"       # <--- Chứa Interface Cha
mkdir -p "$BASE_PATH/Repositories"     # <--- Chứa Repository Cha (Abstract)
mkdir -p "$BASE_PATH/Providers"
mkdir -p "$BASE_PATH/Support/Helpers"
mkdir -p "$BASE_PATH/Support/Traits"

# --- TẠO CODE MẪU ---

# 1. Interface Cha (RepositoryInterface)
# Định nghĩa các hàm mà mọi Repository trong hệ thống phải có
cat <<EOT > "$BASE_PATH/Interfaces/RepositoryInterface.php"
<?php

namespace Modules\\Shared\\Interfaces;

interface RepositoryInterface
{
    public function getAll();
    public function findById(int \$id);
    public function create(array \$data);
    public function update(int \$id, array \$data);
    public function delete(int \$id);
}
EOT

# 2. Repository Cha (BaseRepository) - IMPLEMENT Interface trên
# Class này sẽ viết logic Eloquent 1 lần duy nhất để dùng lại
cat <<EOT > "$BASE_PATH/Repositories/BaseRepository.php"
<?php

namespace Modules\\Shared\\Repositories;

use Modules\\Shared\\Interfaces\\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{
    protected Model \$model;

    public function __construct()
    {
        \$this->setModel();
    }

    // Hàm trừu tượng bắt buộc class con phải khai báo Model nào
    abstract public function getModel();

    public function setModel()
    {
        \$this->model = app()->make(\$this->getModel());
    }

    public function getAll()
    {
        return \$this->model->all();
    }

    public function findById(int \$id)
    {
        return \$this->model->findOrFail(\$id);
    }

    public function create(array \$data)
    {
        return \$this->model->create(\$data);
    }

    public function update(int \$id, array \$data)
    {
        \$record = \$this->findById(\$id);
        \$record->update(\$data);
        return \$record;
    }

    public function delete(int \$id)
    {
        return \$this->model->destroy(\$id);
    }
}
EOT

# 3. Trait ApiResponse (Chuẩn phản hồi JSON)
cat <<EOT > "$BASE_PATH/Support/Traits/ApiResponse.php"
<?php

namespace Modules\\Shared\\Support\\Traits;

trait ApiResponse
{
    public function success(\$data = [], \$message = 'Success', \$code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => \$message,
            'data' => \$data
        ], \$code);
    }

    public function error(\$message = 'Error', \$code = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => \$message,
        ], \$code);
    }
}
EOT

# 4. Enum Status chung
cat <<EOT > "$BASE_PATH/Enums/GeneralStatus.php"
<?php

namespace Modules\\Shared\\Enums;

enum GeneralStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
EOT

# 5. Service Provider
cat <<EOT > "$BASE_PATH/Providers/SharedServiceProvider.php"
<?php

namespace Modules\\Shared\\Providers;

use Illuminate\Support\ServiceProvider;

class SharedServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Ở Shared thường chỉ bind các dịch vụ tiện ích global
    }

    public function boot(): void
    {
        // Load gì đó nếu cần
    }
}
EOT

echo "Đã chuẩn hóa Module Shared thành công (Có BaseRepository & Interface)!"