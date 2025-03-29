<?php

namespace App\Console\Commands;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');

        $path = app_path("Repositories/{$name}Repository.php");
        if (file_exists($path)) {
            $this->error("El repositorio {$name}Repository ya existe.");
            return;
        }

        $repositoryPath = app_path("Repositories/{$name}Repository.php");
        $stub = "<?php\n\nnamespace App\Repositories;\n\nuse App\Models\\{$name};\n\nclass {$name}Repository\n{\n    public function create(array \$data)\n    {\n        return {$name}::create(\$data);\n    }\n}";

   

        $this->writeFile($repositoryPath, $stub);

        $this->info("Service '{$name}' generado correctamente.");
    }
    private function writeFile($path, $content)
    {
        $filesystem = new Filesystem();
        if (!$filesystem->exists(dirname($path))) {
            $filesystem->makeDirectory(dirname($path), 0755, true);
        }
        if (!$filesystem->exists($path)) {
            $filesystem->put($path, $content);
        } else {
            $this->warn("El archivo ya existe: {$path}");
        }
    }
}
