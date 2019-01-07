- Framework Laravel 5.7 https://laravel.com/docs/5.7

- Requerimientos:
  
  php >= 7.0
  
  mysql >= 5.7
  
  composer

- Una vez clonado el proyecto en un ambiente y configurada la base de datos con sus respectivos accesos en el 
archivo .env correr los singuientes comandos:

   composer update
   
   php artisan migrate

   php artisan db:seed

   php artisan migrate:fresh --seed
   

- Ingresar a la aplicacion por http a través del navegador y registrarse para poder acceder.

- Para correr el cron que revisa las transacciones pendientes por http se debe ejecutar http://dominio/cronReviewTransactions

- Nota: se puede programar el cron por medio del servidor accediendo al comando crontab -e 