
# Proyecto API REST Laravel 10

## Descripción del Proyecto

Este proyecto es una aplicación web desarrollada en Laravel 10 , un framework de PHP, diseñada para para poder registrar leed que no esten duplicados en la entidad cliente.

## Enfoque y Decisiones de Diseño

En este API Rest, hemos aplicado clean code y algunos principios SOLID. Hemos separado la lógica de lo que recibe cada función de crear o editar para realizar validaciones de los datos y llevar a cabo consultas a un API REST de EJEMPLO, como por ejemplo https://dev-nc6s8imsfismfco.api.raw-labs.com/score-leads, que devuelve un JSON APTO.

Para guardar los datos si no existe en la tabla clients el leed se puede aplicar varias soluciones al respeto y no lo realizaria en el controlador si no en el modelo lead. 
Podemos crear Eventos en el model:
protected $dispatchesEvents = [
        'created' => 'App\Events\EjemploModelCreated',
        'updated' => 'App\Events\EjemploModelUpdated',
        'deleted' => 'App\Events\EjemploModelDeleted',
    ];
Tambien hay otra forma de realizar esta acción y es utilizando esta funcion en el model: 
protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            event(new EjemploModelCreated($model));
        });
    }
No realicé esta acción porque el ejercicio no estaba claro en cuanto a cómo debería llevarse a cabo el intercambio de datos entre ambos modelos.

### Arquitectura

El proyecto sigue una arquitectura basada en el patrón Modelo-Vista-Controlador (MVC) proporcionado por Laravel. La estructura de carpetas sigue las convenciones recomendadas por el framework.

### Base de Datos

Hemos utilizado [motor de base de datos] como base de datos para almacenar [tipo de datos]. La estructura de la base de datos se encuentra en el directorio `database/migrations`. con  la creación de 2 tablas leads y clients, en estos modelos he aplicado uuid a las claves primarias, para api rest es recomendable por temas de cambios de base de datos y seguridad. 

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

## Instalación

1. Clona el repositorio: `git clone https://github.com/tuusuario/tuproject.git`
2. Instala las dependencias de PHP: `composer install`
3. Copia el archivo de configuración: `cp .env.example .env`
4. Configura la base de datos en el archivo `.env`
5. Genera la clave de la aplicación: `php artisan key:generate`
6. Genera la Documentación Api SWAGGER: `php artisan l5-swagger:generate`
7. Ejecuta las migraciones de la base de datos y seeders: `php artisan migrate:fresh --seed`

## Ejecución de Pruebas

Para ejecutar las pruebas, utiliza el siguiente comando:

```bash
php artisan test
