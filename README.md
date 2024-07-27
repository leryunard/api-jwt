<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Estado de compilación"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Descargas totales"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Última versión estable"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="Licencia"></a>
</p>

## Acerca de Laravel

Laravel es un framework de aplicaciones web con una sintaxis expresiva y elegante. Creemos que el desarrollo debe ser una experiencia agradable y creativa para ser verdaderamente satisfactorio. Laravel facilita el desarrollo al simplificar tareas comunes utilizadas en muchos proyectos web, como:

- [Motor de enrutamiento simple y rápido](https://laravel.com/docs/routing).
- [Contenedor de inyección de dependencias potente](https://laravel.com/docs/container).
- Múltiples opciones para almacenamiento de [sesiones](https://laravel.com/docs/session) y [caché](https://laravel.com/docs/cache).
- ORM de base de datos [expresivo e intuitivo](https://laravel.com/docs/eloquent).
- [Migraciones de esquema](https://laravel.com/docs/migrations) independientes de la base de datos.
- [Procesamiento robusto de trabajos en segundo plano](https://laravel.com/docs/queues).
- [Transmisión de eventos en tiempo real](https://laravel.com/docs/broadcasting).

Laravel es accesible, potente y proporciona las herramientas necesarias para aplicaciones grandes y robustas.

## Aprendiendo Laravel

Para comenzar con Laravel, sigue estos pasos:

1. Instala Laravel ejecutando `composer global require laravel/installer`.
2. Crea un nuevo proyecto de Laravel ejecutando `laravel new nombre-del-proyecto`.
3. Cambia al directorio del proyecto con `cd nombre-del-proyecto`.
4. Inicia el servidor de desarrollo ejecutando `php artisan serve`.
5. Visita `http://localhost:8000` en tu navegador para ver la página de bienvenida de Laravel.

Para crear migraciones, controladores, modelos y seeders para tu API, sigue estos pasos:

1. Crea un archivo de migración ejecutando `php artisan make:migration create_nombre_tabla --create=nombre_tabla`.
2. Edita el archivo de migración para definir la estructura de la tabla y las relaciones.
3. Ejecuta la migración ejecutando `php artisan migrate`.
4. Crea un controlador ejecutando `php artisan make:controller NombreControlador`.
5. Edita el archivo del controlador para definir los puntos finales y la lógica de la API.
6. Crea un modelo ejecutando `php artisan make:model NombreModelo`.
7. Edita el archivo del modelo para definir la tabla de la base de datos y las relaciones.
8. Crea un seeder ejecutando `php artisan make:seeder NombreSeeder`.
9. Edita el archivo del seeder para definir los datos a ser sembrados.
10. Ejecuta el seeder ejecutando `php artisan db:seed`.

Siguiendo estos pasos, podrás instalar Laravel, crear los componentes necesarios para tu API y comenzar a construir tu aplicación.

## Autenticación de la API Rest de Laravel usando JWT

Para agregar autenticación a tu API de Laravel usando JWT (JSON Web Tokens), sigue estos pasos:

1. Instala el paquete JWTAuth: `composer require tymon/jwt-auth`
2. Publica la configuración del paquete: `php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"`
3. Genera la clave secreta JWT: `php artisan jwt:secret`
4. Agregue estas variable al `.env` para que podamos cerrar sesión en nuestros usuarios: `JWT_SHOW_BLACKLIST_EXCEPTION=true`

## Patrocinadores de Laravel

Nos gustaría agradecer a los siguientes patrocinadores por financiar el desarrollo de Laravel. Si estás interesado en convertirte en patrocinador, visita el [programa de socios de Laravel](https://partners.laravel.com).

### Patrocinadores Premium

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contribuciones

¡Gracias por considerar contribuir al framework Laravel! La guía de contribución se puede encontrar en la [documentación de Laravel](https://laravel.com/docs/contributions).

## Código de Conducta

Para asegurarnos de que la comunidad de Laravel sea acogedora para todos, por favor revisa y cumple con el [Código de Conducta](https://laravel.com/docs/contributions#code-of-conduct).

## Vulnerabilidades de Seguridad

Si descubres una vulnerabilidad de seguridad en Laravel, por favor envía un correo electrónico a Taylor Otwell a través de [taylor@laravel.com](mailto:taylor@laravel.com). Todas las vulnerabilidades de seguridad serán abordadas de manera rápida.

## Licencia

El framework Laravel es software de código abierto con licencia bajo la [licencia MIT](https://opensource.org/licenses/MIT).


