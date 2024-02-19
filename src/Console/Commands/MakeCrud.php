<?php

namespace Jigardarji\MakePcrudl\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Crud Operation';
    protected $softDelete = true;

    public $name;
    public $fs;
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->name = $this->argument('name');
        $this->fs = new Filesystem();

        $this->controllerGenerate($this->name);
        $this->viewGenerate($this->name);

        $this->line("");
        $this->info("Crud Generated successfully.");
    }

    protected function getStubContent($path)
    {
        $dirPath = str_replace('Console/Commands','stubs/',dirname(__FILE__));
        return $this->fs->get(__DIR__ . '/../../stubs/' . $path . '.stub');
    }

    public function controllerFile()
    {
        return $this->getStubContent("NameHereController.php");
    }

    public function indexViewFile()
    {
        return $this->getStubContent("index.blade.php");
    }

    public function createViewFile()
    {
        return $this->getStubContent("create.blade.php");
    }

    public function editViewFile()
    {
        return $this->getStubContent("edit.blade.php");
    }

    public function controllerGenerate($name)
    {
        $pathController = $this->generateFile('Http/Controllers/'.$name . 'Controller.php', $this->controllerFile(),'app');
        $this->replaceTextFileAgain($pathController, lcfirst($name));
        $this->replaceTextFile($pathController, $name);

        $this->line("Created File: " . 'app/Http/Controllers/'. $name . 'Controller.php');
        return true;
    }

    public function viewGenerate($name)
    {

        $pathIndex = $this->generateFile('views/'. $name . '/index.blade.php', $this->indexViewFile(),'resources',resource_path().'/views/'. $name);
        $pathCreate = $this->generateFile('views/'. $name . '/create.blade.php', $this->createViewFile(),'resources',resource_path().'/views/'. $name);
        $pathEdit = $this->generateFile('views/'. $name . '/edit.blade.php', $this->editViewFile(),'resources',resource_path().'/views/'. $name);
        $this->replaceTextFileAgain($pathIndex, lcfirst($name));
        $this->replaceTextFile($pathIndex, $name);

        $this->replaceTextFileAgain($pathCreate, lcfirst($name));
        $this->replaceTextFile($pathCreate, $name);

        $this->replaceTextFileAgain($pathEdit, lcfirst($name));
        $this->replaceTextFile($pathEdit, $name);

        $this->line("Created File: " . 'resources/views/'. $name . 'index.blade.php');
        $this->line("Created File: " . 'resources/views/'. $name . 'create.blade.php');
        $this->line("Created File: " . 'resources/views/'. $name . 'edit.blade.php');
        return true;
    }

    public function generateFile($path, $file,$type,$folder = null)
    {
        if($type == 'app'){
            $path = app_path($path);
        } else {
            $path = resource_path($path);
        }
        if ($folder != null && !file_exists($folder)) {
            File::makeDirectory(strtolower($folder));
        }
        $fh = fopen($path, 'w') or die("can't open file");
        $stringData = $file;
        fwrite($fh, $stringData);
        fclose($fh);

        return $path;
    }

    public function replaceTextFile($path, $name)
    {
        $str = file_get_contents($path);
        $str = str_replace('NameHere', $name, $str);
        file_put_contents($path, $str);
    }

    public function replaceTextFileAgain($path, $name)
    {
        $str = file_get_contents($path);
        $str = str_replace('smallNameHere', $name, $str);
        file_put_contents($path, $str);
    }
}
