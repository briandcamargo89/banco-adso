<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Banco ADSO</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background: #f0f2f5; margin: 0; padding: 2rem; }
        .box { max-width: 500px; margin: 0 auto; background: #fff; padding: 1.5rem; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .error { background: #fee2e2; color: #991b1b; padding: 0.75rem; border-radius: 4px; margin-bottom: 1rem; }
        nav { margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #eee; }
        nav a { margin-right: 10px; color: #2563eb; text-decoration: none; }
        .field { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.3rem; font-weight: 500; }
        input { width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #2563eb; color: #fff; border: none; padding: 0.6rem 1.2rem; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Banco ADSO</h2>
        <?php if (isset($_SESSION['cuenta_id'])): ?>
            <nav>
                <a href="?ruta=cuenta/panel">Inicio</a>
                <a href="?ruta=transferencia/crear">Transferir</a>
                <a href="?ruta=retiro/crear">Retirar</a>
                <a href="?ruta=auth/logout">Salir</a>
            </nav>
        <?php endif; ?>
        <?= $contenido ?>
    </div>
</body>
</html>