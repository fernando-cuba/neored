# Configuración de proyecto

## Contexto

+ Descripción: El presente proyecto fue realizado como parte de un caso de uso real en formato de prueba técnica
+ Desarrollador: Luis Fernando Cuba Rodriguez
+ Estructura del proyecto:
  + API: Carpeta padre
    + config: Carpeta de configuración
    + controllers: Carpeta de controladores
    + database: Carpeta que contiene conexión a la BD, contiene también un archivo para generación de la BD que veremos más adelante
    + demo: Carpeta que contiene el archivo de ejemplo utilizado
    + documents: Carpeta contenedora de archivos recibidos del bucket
    + models: Carpeta de modelos
    + services: Carpeta de servicios con conexión a servicios externos
    + vendor: Carpeta de configuración de composer
    + views: Carpeta de vistas (No se utilizó)
+ Se puede encontrar una copia del proyecto en la siguiente dirección de Github "archivo"

---

## Procedimiento para importación del proyecto

### 1. Importación de la BD

  1. La estructura de la BD se encuentra en un archivo sql en la siguiente dirección [API/database/importacion_automatica__big_query.sql](API/database/importacion_automatica__big_query.sql)
  2. Solo requiere realizar la importación en su programa administrador de BD preferido
  3. Tener en cuenta las siguiente consideraciones si desea editar el código o agregar campos a la tabla de Logs:
     + El tamaño del archivo se encuentra en Kb
     + Por default se esta tomando el tiempo actual de la BD

### 2. Ejecución del proyecto
  
  Por default se esta considerando que el proyecto esta desplegado en el host [[HOST]/API](http://[HOST]/API/)

  1. La configuración inicial del proyecto se encuentra ubicada en un archivo llamado [config.php](API/config/config.php), el cuál contiene los siguientes datos a configurar (además de contener una configuración inicial con la cuál el proyecto se encuentra funcionando):
     + Zona horario por default: (En este caso, se ocupa America/Mazatlan)
     + Ambiente actual: Posee 3 ambientes, con su respectiva configuración en la cuál comparten propiedades que se utilizan a lo largo del proyecto
        + development: Para desarrollo
        + testing: Para pruebas
        + deployment: Para despliegue
     + Configuración de acceso a BD
     + Configuración de acceso a AWS
     + Configuración de acceso a API NeoRed
  
  ```NOTA: El proyecto actualmente se ejecuta a través de un navegador. Sin embargo, se planea mejorar su funcionalidad para que pueda ser activado desde un CronJob una vez que se tenga acceso a la consola del servidor, para cambiar la configuración del tiempo en que se ejecuta dentro del navegador únicamente se requiere editar la propiedad "TIME_TO_EXEC_PROCESS_IN_SECONDS" en el``` [archivo de configuración](API/config/config.php) ```dentro del ambiente que se encuentre utilizando.```
