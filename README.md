#  Banco ADSO - Sistema de Gestión Bancaria Local

Sistema de operaciones bancarias enfocado en la autenticación de usuarios, consulta de saldos, ejecución de retiros y transferencias en tiempo real con persistencia de datos segura.

---

##  Tecnologías y Herramientas

- Lenguaje: PHP (Nativo)
- Base de Datos: MySQL (`db_banco_adso`)
- Gestión de Paquetes: Composer (Autoloading PSR-4)
- Servidor Local: PHP Built-in Server (`localhost:8000`)
- Estilos: HTML5 y CSS3 nativo

---

## Arquitectura y Seguridad

El proyecto fue desarrollado aplicando patrones de arquitectura de software para garantizar un código modular, mantenible y seguro:

- Modelo - Vista - Controlador (MVC): Desacoplamiento total entre la lógica del servidor, la gestión de datos y las vistas presentadas al usuario.
- Patrón Repository: Centralización de las consultas SQL dentro de clases especializadas (`RepositorioRetiros`, `RepositorioTransferencias`, `RepositorioCuentas`).
- Conexión Singleton: Uso de la clase `Conexion` para manejar una sola instancia de `PDO` y optimizar recursos.
- Transacciones : Garantía de integridad de datos en retiros y transferencias usando `beginTransaction()`, `commit()` y `rollBack()`.
- Seguridad Integrada:
  - Control de acceso por sesión (`$_SESSION['usuario']`).
  - Consultas preparadas con `PDO` para mitigar **Inyección SQL.
  - Sanitización de datos en vistas con `htmlspecialchars()` para prevenir ataques XSS.

---

## 📁 Estructura del Proyecto

```text
BancoADSOO/
├── public/
│   └── index.php                        # Punto de entrada y enrutador principal
├── src/
│   ├── Controladores/
│   │   ├── AutenticacionControlador.php # Manejo de login y logout
│   │   ├── CuentaControlador.php        # Consulta de panel y saldos
│   │   ├── RetiroControlador.php        # Procesamiento de retiros
│   │   └── TransferenciaControlador.php # Procesamiento de transferencias
│   ├── Repositorios/
│   │   ├── RepositorioRetiros.php       # Consultas SQL para la tabla 'retiros'
│   │   └── RepositorioTransferencias.php# Consultas SQL para la tabla 'transferencias'
│   ├── Nucleo/
│   │   ├── Router.php                   # Enrutador de peticiones GET y POST
│   │   ├── Conexion.php                 # Conexión Singleton a MySQL
│   │   └── Vista.php                    # Renderizado de vistas
│   └── Excepciones/
│       └── SaldoInsuficienteException.php # Control de errores de saldo
├── vistas/
│   ├── autenticacion/                   # Vista de login
│   ├── cuenta/                          # Panel principal del usuario
│   ├── retiros/                         # Formulario de retiro
│   └── transferencias/                  # Formulario de transferencia
├── vendor/                              # Autoload de Composer
├── composer.json                        # Definición del espacio de nombres App\
└── README.md                            # Documentación del proyecto