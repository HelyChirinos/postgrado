
# Instalación Sistema SIPADU

El Sistema SIPADU fue desarrollado con laravel 11 y Bootstrap 5

  ## Requisitos
  Los requisitos mínimos para la instalación de Proyecto son:git status 
 - php 8.2 o Mayor
 - Base de datos : MariaDB ó Mysql
 - Composer
 - node.js

  ## Instalación

### 1. Clonar proyecto del repositorio de GitHub

Dentro de la carpeta Raíz del servidor web , Ingrese el comando :

git clone https://github.com/HelyChirinos/postgrado.git

cambie al nuevo directorio del proyecto



### 2. Otorgar Permisos

ejecutar los comandos:
chmod -R 775 public && sudo chmod -R 777 storage
php artisan storage:link


### 3. Instalar las Dependencias de Composer

Ingrese el comando:

composer install

  

### 4. Instalar las Dependencias de NPM

Ingrese el comando:

npm install

npm run build


### 5. Generar el App Encryption Key

Ingrese el comando:

php artisan key:generate




### 6. Crear una base de Datos vacía para el sistema

 - Utilice su gestor de Base de Datos favorito y cree una Base de Datos vacía.

 - Configure el username y el password.

  
### 7. Crear el archivo .env

copie el archivo .env.example a el archivo .env:

cp .env.example .env

   

### 8. Configure el archivo .env 

Edite el archivo .env y coloque los valores correctos de :

DB_CONNECTION=mysql<br/>
DB_HOST=127.0.0.1<br/>
DB_PORT=3306<br/>
DB_DATABASE=laravel<br/>
DB_USERNAME=root (el que usted creo)<br/>
DB_PASSWORD=********    (el que usted creo)<br/>

También Actualice los valores de mail:

MAIL_MAILER=smtp<br/>
MAIL_HOST=mailhog<br/>
MAIL_PORT=1025<br/>
MAIL_USERNAME=null <br/>
MAIL_PASSWORD=null <br/>
MAIL_ENCRYPTION=null<br/>
MAIL_FROM_ADDRESS=null<br/>
MAIL_FROM_NAME="${APP_NAME}"<br/>

Por último, Coloque los valores correspondientes en:

APP_NAME=SIPADU<br/>
APP_DEBUG=false<br/>
APP_TIMEZONE=America/Caracas<br/>
APP_URL=http://sipadu.test<br/>



### 9. Importar la Base de Datos
Utilice su gestor de Base de Datos e importe los datos de postgrado.sql
