
# SysOp Prueba Técnica

## Requisitos Previos
- PHP >= 8.1
- MySQL >= 5.7
- Composer
- Yarn

## Ejecutar en desarrollo

1. Clonar el repositorio

2. Instalar dependencias PHP con Composer:
   ```
   composer install
   ```
3. Instalar dependencias JavaScript con Yarn:

   ```
   yarn install
   ```

4. Clonar el archivo ```.env.template``` y renombrarlo la copia ```.env```

4. Llenar las variables de entorno definidas en el archivo ```.env```

5. Crear la base de datos ejecutando el archivo `db.sql`.

6. Para entrar como modo administrador modificar el campo ```admin``` a ```true```

7. Iniciar el servidor local:
```
   cd public
   php -S localhost:80
```

8. Iniciar sesión con el correo de ```giancarlozapata13@gmail.com``` y contraseña de ```123456```


## Recomendaciones
* Utilizar [Mailtrap](https://mailtrap.io/) para el servicio de envío de correos.

## Stack Usado
* PHP con MySQL
* PHPMailer