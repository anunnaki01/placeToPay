# Framework Laravel 5.7 https://laravel.com/docs/5.7

# Requerimientos:
  
  php >= 7.0
  
  mysql >= 5.7
  
  composer
  
 #Instalacion
 
 Crear las bases de datos:
- Aplicacion : "place_to_pay"
- Pruebas : "place_to_pay_tests"

Nota: los accesos de la base de datos se encuentran en el archivo .env
en caso de tener un usuario y password diferentes se deben cambiar en el archivo.

- Una vez clonado el proyecto en un ambiente y configurada la base de datos con sus respectivos accesos en el 
archivo .env correr los singuientes comandos:

   composer update
   
   php artisan migrate

   php artisan db:seed

   php artisan migrate:fresh --seed
   
- Copiar las tablas generadas en "place_to_pay" a "place_to_pay_tests"

- Ingresar a la aplicacion por http a través del navegador y registrarse para poder acceder.

- Para correr el cron que revisa las transacciones pendientes por http se debe ejecutar http://dominio/cronReviewTransactions

- Nota: se puede programar el cron por medio del servidor accediendo al comando crontab -e y agregando éste a la lista.

 #Pruebas Unitarias
 
-Para correr las pruebas unitarias del proyecto las cuales prueban algunas funcionalidades, se debe utilizar el sigiente comando:

  vendor/bin/phpunit