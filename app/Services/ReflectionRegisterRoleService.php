<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;

class ReflectionRegisterRoleService
{
    public array $controllers = [];
    public array $roles = [];
    public array $permissions = [];

    public function __construct()
    {
        $this->controllers = $this->reflectionController();
    }
    public function reflectionController(): array
    {
        $routes = [];
        foreach (Route::getRoutes()->getRoutes() as $route)
        {
            $action = $route->getAction();
            if (array_key_exists('controller', $action))
            {
                $class = explode('@', $action['controller']);
                if(str_contains($class[0], 'App\Http\Controllers')){
                    if(isset($class[1])){
                        $routes[$class[0]][] = $class[1];
                    }
                }

            }
        }
        return $routes;
    }
    public function reflectionRegisterRole(): array
    {
        foreach ($this->controllers as $controller=>$methods){
            $role = $this->getControllerName($controller);
            if(method_exists($controller, '__construct')){
                $comments = $this->phpDocParse(new \ReflectionMethod($controller, '__construct'));
                if(!empty($comments['@name'][0])){
                    $this->roles[$role]['__construct'] = $comments['@name'][0];
                }
            }
            foreach ($methods as $method){
                if(method_exists($controller, $method)){
                    $comments = $this->phpDocParse(new \ReflectionMethod($controller, $method));
                    if(!empty($comments['@name'][0])){
                        $this->roles[$role][$method] = $comments['@name'][0];
                    }
                }
            }
        }
        return $this->roles;
    }

    private function getControllerName(string $controller): string
    {
        $array = explode('\\', $controller);
        return end($array);
    }

    private function phpDocParse(\ReflectionMethod $method): array
    {
        // Retrieve the full PhpDoc comment block
        $doc = $method->getDocComment();

        // Trim each line from space and star chars
        $lines = array_map(function($line){
            return trim($line, " *");
        }, explode("\n", $doc));

        // Retain lines that start with an @
        $lines = array_filter($lines, function($line){
            return str_starts_with($line, "@");
        });

        $args = [];

        // Push each value in the corresponding @param array
        foreach($lines as $line){
            list($param, $value) = explode(' ', $line, 2);
            $args[$param][] = $value;
        }

        return $args;
    }
}
