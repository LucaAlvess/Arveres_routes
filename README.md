# Arveres routes

**Arveres routes**, é um simples gerenciador de rotas, com features básicas de routeamento com PHP.

## Instalação

Para instalar **Arveres routes**, você pode utilizar o comando composer diretamente
em seu terminal:
```
$ composer require arveres/route
```
Ou você pode adicionar a seguinte linha em seu arquivo `composer.json`.

```
{
    "require": {
        "arveres/route": "^1.0"
    }
}
```
Em seguida, execute o comando:
```
$ composer install
```
## Exemplo de uso:
```php
require_once 'vendor/autoload.php';

use ArveresRoute\Http\Router;

$router = new Router;

//Rota básica GET
$router->get('/', [UserController::class, 'index']);

//Rota básica POST
$router->post('/user/register', [UserController::class, 'store']);

// Rotas com parâmetros dinâmicos
$router->get('/user/{id}', [UserController::class, 'show']);

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
        var_dump('hello World show');
    }
}
```
### Requisitos
- PHP 8.0 ou superior