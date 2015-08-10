# VOIQ Test
Ejemplo de uso de Laravel para crear un sencillo manejador de usuarios y contactos.
## Librerias usadas:
### "laravelcollective/html": "~5.0"
Soporte a html injectado en los archivos blade, en este caso se utilizo para que laravel manejara correctamente la subida del spreadsheet con los contactos.

``` php
{!! Form::open(array('url' => 'contacts/import_contacts',
                     'method' => 'post',
                     'class' => 'form',
                     'novalidate' => 'novalidate',
                     'files' => true)) !!}
```
### "zizaco/entrust": "dev-laravel-5"
Usado para el manejo de roles en la aplicación en conjunto con el middleware (Auth) que viene con Laravel.
``` php
Entrust::routeNeedsPermission('admin/*', 'edit-users',Redirect::to('errors/403'));
```
### "propaganistas/laravel-phone": "~2.0"
Para evitar el desarrollo de un validator propio para la condición: "phone number (US only, supporting multiple entries)", se uso esta libreria en conjunto con el validator de laravel.
### "maatwebsite/excel": "~2.0.0"
Libreria que integra PHPExcel facilmente a Laravel, se uso para leer correctamente los archivos xls y xlsx con los que se importan los contactos.
### "parsecsv/php-parsecsv": "0.4.5"
Libreria usada para leer los archivos csv y tsv con los que se importan los contactos.

## Codigo propio implementado:
### Controllers:
1. AdminController:
Agrupa todos los comportamientos de las paginas a las que puede acceder el administrador, quien puede crear, eliminar o editar usuarios.

2. ContactsController:
Agrupa todos los comportamientos de las paginas a las que puede acceder el usuario excepto la de importar contactos.

3. ImportController:
Funciones para subir el archivo e insertar los contactos.

### Models:
Todos los modelos son implementados, User esta por defecto pero se hicieron algunas modificaciones.

- Contact
- ContactEmail
- ContactImportLog
- ContactNumber
- Permission
- Role
- User

### DML:
Se agrega el esquema de la base de datos en database/DML, pero la base de datos se debe manejar con los migrations.

### Migrations y seeds:
Se crean las migraciones apropiadas para inicializar la base de datos y un custom seeder para generar informacion inicial basica.

## Initial setup:
Se debe crear una base de datos y cambiar el nombre en .env y config/database.php, luego se debe correr:
```
php artisan migrate:refresh --seed
```
En el database seed se crean dos usuarios por defecto:
- Admin:
```
'email' => 'email1@example.com',
'password' => 'password',
```
- User:
- Admin:
```
'email' => 'user1@email.com',
'password' => 'password',
```

## Archivos de prueba:
Los archivos de prueba para subir contactos estan en la carpeta tests/Data.

## TODOs:
1. Tests
2. Implementar la carga de contactos en archivos CSV y TSV.
3. Actualizacion de contactos.
4. Delete de emails y telefonos adicionales en el formulario de crear contactos.