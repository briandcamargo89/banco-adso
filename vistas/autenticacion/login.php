<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco ADSO - Iniciar Sesión</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 100%; max-width: 380px; }
        .login-card h2 { margin-top: 0; color: #1a365d; text-align: center; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; color: #4a5568; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 4px; box-sizing: border-box; }
        .btn { width: 100%; padding: 10px; background-color: #2b6cb0; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; font-weight: bold; }
        .btn:hover { background-color: #2c5282; }
        .error { background-color: #fed7d7; color: #9b2c2c; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center; font-weight: bold; }
    </style>
</head>
<body>

<div class="login-card">
    <h2>Banco ADSO</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="/login" method="POST">
        <div class="form-group">
            <label for="numero_cuenta">Número de Cuenta</label>
            <input type="text" id="numero_cuenta" name="numero_cuenta" required placeholder="Ej. 1001" autofocus>
        </div>

        <div class="form-group">
            <label for="clave">Contraseña</label>
            <input type="password" id="clave" name="clave" required placeholder="••••••••">
        </div>

        <button type="submit" class="btn">Ingresar</button>
    </form>
</div>

</body>
</html>