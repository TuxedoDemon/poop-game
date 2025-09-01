<?php // AutoLoader.php - kicks everything off
declare(strict_types=1);

class AutoLoader {

    public static function AutoLoad(): void {

        \spl_autoload_register(function (string $class){
            
            $path = \str_replace('\\', '/', $class);
            $file =  __DIR__ . "/{$path}.php"; 

            if(\file_exists($file)){
                require $file;
            }
            
        });

    }

}

AutoLoader::AutoLoad();
