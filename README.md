# Arveres routes

**Arveres routes**, é um simples gerenciador de rotas, com features básicas de routeamento com PHP.

## Instalação

Para instalar **Arveres routes**, você pode utilizar o comando composer diretamente
em seu terminal:
```shell
$ composer require arveres/route
```
Ou você pode adicionar a seguinte linha em seu arquivo `composer.json`.

```
{
    "require": {
        "arveres/route": "^1.1"
    }
}
```
Em seguida, execute o comando:
```shell
$ composer install
```
## Exemplo de uso:
```php
require_once 'vendor/autoload.php';

use ArveresRoute\Http\Router;

$router = new Router; //Instância de Router

//Rota básica GET
$router->get('/', [HomeController::class, 'index']);

//Rota básica POST
$router->post('/user/register', [UserController::class, 'store']);

// Rotas com parâmetros dinâmicos
$router->get('/user/{id}', [UserController::class, 'show']);

// Rotas com middlewares
//Middlewares passado como array no terceiro parâmetro.
// O nome do middleware passado como parâmetro deve estar registrado com a classe Queue
$router->get('/list', [HomeController::class, 'list'], ['maintenance']);

// Executa as rotas
$router->run();
```

## Exemplo controladores

```PHP
class HomeController
{   
    // Todo controlador associado a rota possui como parâmetro
    // Uma instância de Request que pode ser omitido.
    public function index()
    {
        echo 'Página inicial :)';
    }
}

class UserController
{
    // Instância de Request como parâmetro ao método controlador
    public function store(Request $request)
    {
        UserModel::create($request->allPost());
        //...
    }

    // Em rotas dinâmicas, o método do controlador associado
    // Recebe como parâmetro o nome da variável da rota dinâmica
    // OBS: Os parâmetros devem seguir a ordem das variáveis da rota
    // Por fim possuem uma instância de Request
    public function show($id, Request $request)
    {
        UserModel::findBy($id):
        /...
    }
}
```
## Middlewares Exemplo

```PHP
use ArveresRoute\Http\Middlewares\Queue; // Referência para Queue

// Registra middlewares
Queue::routeMiddleware([
    'maintenance' => \ArveresRoute\Http\Middlewares\Maintenance::class,
    'stringTrim' => \ArveresRoute\Http\Middlewares\trimString::class
]);

// Define middleware padrão para todas as rotas
Queue::middlewareDefault([
    'maintenance',
    'stringTrim'
]);
```
## Exemplo middleware
```PHP
// A biblioteca possui um interface opcional que pode ser utilizado nas classes de middleware
interface MiddlewareInterface // ArveresRoute\Http\Middlewares;
{
    public function handle(Request $request, Closure $next);
}

// Exemplo de middleware
class Maintenance implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next)
    {
        $ItIsInMaintenance = true;
        if (true === $ItIsInMaintenance) {
            throw new \Exception('A aplicação está em manutenção. Por favor, tente mais tarde', 200);
        }

        return $next($request);
    }
}
```

### Requisitos
- PHP 8.0 ou superior
