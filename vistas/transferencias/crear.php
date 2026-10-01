<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco ADSO - Realizar Transferencia</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        .card h2 { margin-top: 0; color: #1a365d; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; color: #4a5568; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 4px; box-sizing: border-box; }
        .btn { width: 100%; padding: 10px; background-color: #3182ce; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; text-align: center; text-decoration: none; display: inline-block; box-sizing: border-box; }
        .btn-secondary { background-color: #718096; margin-top: 10px; }
        .error { background-color: #fed7d7; color: #9b2c2c; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="card">
    <h2>Realizar Transferencia</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="/transferencias/crear" method="POST">
        <div class="form-group">
            <label for="numero_cuenta">Cuenta Destino</label>
            <input type="text" id="numero_cuenta" name="numero_cuenta" required placeholder="Ej. 1002" autofocus>
        </div>

        <div class="form-group">
            <label for="monto">Monto a transferir ($)</label>
            <input type="number" step="0.01" id="monto" name="monto" min="1" required placeholder="Ej. 150.00">
        </div>

        <button type="submit" class="btn">Confirmar Transferencia</button>
        <a href="/cuenta" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
</html>