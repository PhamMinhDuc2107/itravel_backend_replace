<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class MakeModuleCrud extends Command
{
    // Lệnh bạn sẽ gõ: php artisan module:make-crud {Module} {Name}
    // Ví dụ: php artisan module:make-crud Tour Promotion
    protected $signature = 'module:make-crud {module : Tên Module (VD: Tour)} {name : Tên Entity (VD: Promotion)}';

    protected $description = 'Tự động tạo full bộ CRUD (Model, Entity, Repo, Service, Controller, Request, Resource) chuẩn Modular';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $module = Str::studly($this->argument('module')); // VD: Tour
        $name = Str::studly($this->argument('name'));     // VD: Promotion
        
        $this->info("Đang khởi tạo CRUD cho $name trong Module $module...");

        // Danh sách các file cần tạo
        $components = [
            'Entity' => [
                'path' => "Modules/$module/Entities/$name.php",
                'stub' => $this->getEntityStub($module, $name)
            ],
            'Model' => [
                'path' => "Modules/$module/Models/{$name}Model.php",
                'stub' => $this->getModelStub($module, $name)
            ],
            'Interface' => [
                'path' => "Modules/$module/Interfaces/{$name}RepositoryInterface.php",
                'stub' => $this->getInterfaceStub($module, $name)
            ],
            'Repository' => [
                'path' => "Modules/$module/Repositories/{$name}Repository.php",
                'stub' => $this->getRepoStub($module, $name)
            ],
            'Service' => [
                'path' => "Modules/$module/Services/{$name}Service.php",
                'stub' => $this->getServiceStub($module, $name)
            ],
            'DTO' => [
                'path' => "Modules/$module/DTO/{$name}Data.php",
                'stub' => $this->getDTOStub($module, $name)
            ],
            'Request' => [
                'path' => "Modules/$module/Http/Requests/Store{$name}Request.php",
                'stub' => $this->getRequestStub($module, $name)
            ],
            'Resource' => [
                'path' => "Modules/$module/Http/Resources/{$name}Resource.php",
                'stub' => $this->getResourceStub($module, $name)
            ],
            'Controller' => [
                'path' => "Modules/$module/Http/Controllers/{$name}Controller.php",
                'stub' => $this->getControllerStub($module, $name)
            ],
        ];

        foreach ($components as $key => $component) {
            $this->createFile($component['path'], $component['stub'], $key);
        }

        $this->info("------------------------------------------------");
        $this->comment("⚠️  LƯU Ý QUAN TRỌNG:");
        $this->comment("Đừng quên đăng ký Binding trong file: Modules/$module/Providers/{$module}ServiceProvider.php");
        $this->info("\$this->app->bind(\Modules\\$module\Interfaces\\{$name}RepositoryInterface::class, \Modules\\$module\Repositories\\{$name}Repository::class);");
        $this->info("------------------------------------------------");
        $this->info("DONE! 🚀");
    }

    protected function createFile($path, $content, $type)
    {
        if ($this->files->exists($path)) {
            $this->error("$type đã tồn tại: $path");
            return;
        }

        // Tạo thư mục nếu chưa có
        $directory = dirname($path);
        if (!$this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }

        $this->files->put($path, $content);
        $this->line("<info>Created $type:</info> $path");
    }

    // --- CÁC MẪU CODE (STUBS) ---

    protected function getEntityStub($module, $name)
    {
        return <<<EOT
<?php

namespace Modules\\{$module}\\Entities;

class {$name}
{
    public function __construct(
        public ?int \$id,
        public string \$name,
        // Thêm các thuộc tính khác...
    ) {}
}
EOT;
    }

    protected function getModelStub($module, $name)
    {
        $table = Str::lower(Str::plural($name));
        return <<<EOT
<?php

namespace Modules\\{$module}\\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class {$name}Model extends Model
{
    use HasFactory;
    
    protected \$table = '{$table}';
    protected \$fillable = ['name'];
}
EOT;
    }

    protected function getInterfaceStub($module, $name)
    {
        return <<<EOT
<?php

namespace Modules\\{$module}\\Interfaces;

use Modules\\Shared\\Interfaces\\RepositoryInterface;

interface {$name}RepositoryInterface extends RepositoryInterface
{
    // Định nghĩa thêm hàm riêng nếu cần
}
EOT;
    }

    protected function getRepoStub($module, $name)
    {
        return <<<EOT
<?php

namespace Modules\\{$module}\\Repositories;

use Modules\\Shared\\Repositories\\BaseRepository;
use Modules\\{$module}\\Interfaces\\{$name}RepositoryInterface;
use Modules\\{$module}\\Models\\{$name}Model;

class {$name}Repository extends BaseRepository implements {$name}RepositoryInterface
{
    public function getModel()
    {
        return {$name}Model::class;
    }
}
EOT;
    }

    protected function getDTOStub($module, $name)
    {
        return <<<EOT
<?php

namespace Modules\\{$module}\\DTO;

use Illuminate\Http\Request;

readonly class {$name}Data
{
    public function __construct(
        public string \$name,
    ) {}

    public static function fromRequest(Request \$request): self
    {
        return new self(
            name: \$request->validated('name'),
        );
    }
}
EOT;
    }

    protected function getServiceStub($module, $name)
    {
        return <<<EOT
<?php

namespace Modules\\{$module}\\Services;

use Modules\\{$module}\\Interfaces\\{$name}RepositoryInterface;
use Modules\\{$module}\\DTO\\{$name}Data;

class {$name}Service
{
    public function __construct(
        protected {$name}RepositoryInterface \$repository
    ) {}

    public function getAll()
    {
        return \$this->repository->getAll();
    }

    public function create({$name}Data \$data)
    {
        return \$this->repository->create((array) \$data);
    }
}
EOT;
    }

    protected function getRequestStub($module, $name)
    {
        return <<<EOT
<?php

namespace Modules\\{$module}\\Http\\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Store{$name}Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
EOT;
    }

    protected function getResourceStub($module, $name)
    {
        return <<<EOT
<?php

namespace Modules\\{$module}\\Http\\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class {$name}Resource extends JsonResource
{
    public function toArray(Request \$request): array
    {
        return [
            'id' => \$this->id,
            'name' => \$this->name,
            'created_at' => \$this->created_at,
        ];
    }
}
EOT;
    }

    protected function getControllerStub($module, $name)
    {
        return <<<EOT
<?php

namespace Modules\\{$module}\\Http\\Controllers;

use App\Http\Controllers\Controller;
use Modules\\Shared\\Support\\Traits\\ApiResponse;
use Modules\\{$module}\\Services\\{$name}Service;
use Modules\\{$module}\\Http\\Requests\\Store{$name}Request;
use Modules\\{$module}\\Http\\Resources\\{$name}Resource;
use Modules\\{$module}\\DTO\\{$name}Data;

class {$name}Controller extends Controller
{
    use ApiResponse;

    public function __construct(
        protected {$name}Service \$service
    ) {}

    public function index()
    {
        \$items = \$this->service->getAll();
        return \$this->success({$name}Resource::collection(\$items));
    }

    public function store(Store{$name}Request \$request)
    {
        \$data = {$name}Data::fromRequest(\$request);
        \$item = \$this->service->create(\$data);
        return \$this->success(new {$name}Resource(\$item), 'Tạo mới thành công', 201);
    }
}
EOT;
    }
}