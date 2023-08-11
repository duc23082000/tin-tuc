<?php

namespace App\Commands;

use Illuminate\Console\Command;

class CreateModelFilter extends Command
{
    /**
     * The name and signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:modelFilter {name} {modelExtend}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model filter';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $modelExtend = $this->argument('modelExtend');

        $path = app_path("ModelFilters/{$name}.php");

        if (file_exists($path)) {
            $this->error("Model '$name' already exists");
            return 1;
        }

        if (!file_exists(app_path('ModelFilters'))) {
            mkdir(app_path('ModelFilters'));
        }


        $content = <<<PHP
<?php

namespace App\ModelFilters;

use App\Models\\$modelExtend;

class {$name} extends {$modelExtend}
{
    public function list$modelExtend(){
        
    }
}
PHP;

        file_put_contents($path, $content);

        
        $this->info('
        ModelFilter ['.$path.'] created successfully
        ');
        

    }
}