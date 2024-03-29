
# Proyecto API REST Laravel 10

## Descripción del Proyecto

Este proyecto es una aplicación web desarrollada en Laravel 10 , un framework de PHP, diseñada para para poder registrar leed que no esten duplicados en la entidad cliente.

## Enfoque y Decisiones de Diseño

En este API Rest, hemos aplicado clean code y algunos principios SOLID. Hemos separado la lógica de lo que recibe cada función de crear o editar para realizar validaciones de los datos y llevar a cabo consultas a un API REST de EJEMPLO, como por ejemplo https://dev-nc6s8imsfismfco.api.raw-labs.com/score-leads, que devuelve un JSON APTO.

Para guardar los datos si no existe en la tabla clients el leed se puede aplicar varias soluciones al respeto y no lo realizaria en el controlador si no en el modelo lead. 
Podemos crear Eventos en el model:
```php
<?php
protected $dispatchesEvents = [
        'created' => 'App\Events\EjemploModelCreated',
        'updated' => 'App\Events\EjemploModelUpdated',
        'deleted' => 'App\Events\EjemploModelDeleted',
    ];
?>
```
Tambien hay otra forma de realizar esta acción y es utilizando esta funcion en el model:
```php
<?php
protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            event(new EjemploModelCreated($model));
        });
    }
?>
```
No realicé esta acción porque el ejercicio no estaba claro en cuanto a cómo debería llevarse a cabo el intercambio de datos entre ambos modelos.

Para una gestion de errores en la api he aplicado una captura de excepciones  en el fichero `app\Exceptions\Handler.php` ademas de retornar en formato json la excepción tambien la regitro en log de laravel para asi tener un control de lo errores que estan ocurriendo en el sistema. 
```php
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            Log::error("Error:".$e->getMessage());
            return response()->json(['message'=>$e->getMessage()],Response::HTTP_INTERNAL_SERVER_ERROR);
        });
        $this->reportable(function (Throwable $e) {
            Log::error("Error:".$e->getMessage());
            return response()->json(['message'=>$e->getMessage()],Response::HTTP_INTERNAL_SERVER_ERROR);
        });
        $this->renderable(function(NotFoundHttpException $e,Request $request){
            Log::warning($e->getMessage());
            if($request->is('api/*')){
                return response()->json(['message'=>$e->getMessage()],Response::HTTP_NOT_FOUND);
            }
        });
        $this->renderable(function(ValidationException $e,Request $request){
            Log::warning($e->getMessage());
            return response()->json(['message'=>$e->getMessage(),'errors'=>$e->errors()],Response::HTTP_UNPROCESSABLE_ENTITY);
        });
        $this->renderable(function(RequestException $e,Request $request){
            Log::warning($e->getMessage());
            return response()->json(['message'=>$e->getMessage()],Response::HTTP_FORBIDDEN);
        });

    }
```
Con respeto a los test unitarios he realizado unos test muy basicos que consiste en controlar los codigos de respuestas de las peticiones al api, no se realiza vereficaciones de lo que retorna y tampoco he aplicado test casuisticas de validación en los metodos de crear y editar. 

### Arquitectura

El proyecto sigue una arquitectura basada en el patrón Modelo-Vista-Controlador (MVC) proporcionado por Laravel. La estructura de carpetas sigue las convenciones recomendadas por el framework.

### Base de Datos

He utilizado [motor de base de datos] como base de datos para almacenar [tipo de datos]. La estructura de la base de datos se encuentra en el directorio `database/migrations`. con  la creación de 2 tablas leads y clients, en estos modelos he aplicado uuid a las claves primarias, para api rest es recomendable por temas de cambios de base de datos y seguridad. 

### Seguridad

Para esta prueba tecnica no aplica, si llegaramos a securizar la api podemos implementar laravel passaport, o Spatie Permissions para realizar una api con autentificación con token.

### Frontend

No aplica para esta prueba, si fuese una aplicación monolito suelo desarrollar con livewire y bootstrap. 

### API

Este proyecto incluye una API, se proporciona una documentación con Swagger detallada en el directorio http://dominiolocal.test/`api/documentation`.

## Requisitos del Sistema

- PHP PHP 8.1 en adelante. 
- Composer
- Base de datos Mysql
- Apache o Ngix

## Instalación

1. Clona el repositorio: 
```bash
git clone https://github.com/davidblancolf/testleads
```
2. Instala las dependencias de PHP: 
```bash
composer install
```
3. Copia el archivo de configuración:
```bash
 cp .env.example .env
```
4. En el archivo `.env`, configura las variables relacionadas con la base de datos:

```env
APP_URL=http://localhost
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=nombre_de_usuario
DB_PASSWORD=contraseña
```

5. Genera la clave de la aplicación:
```bash
php artisan key:generate
```
6. Genera la Documentación Api SWAGGER: 
```bash
php artisan l5-swagger:generate
```
7. Ejecuta las migraciones de la base de datos y seeders:
```bash 
php artisan migrate:fresh --seed
```

## Ejecución de Pruebas

Para ejecutar las pruebas, utiliza el siguiente comando:

```bash
php artisan test
