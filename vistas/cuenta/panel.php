<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco ADSO - Mi Cuenta</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #e2e8f0; padding-bottom: 15px; margin-bottom: 20px; }
        .card { background: #ebf8ff; border-left: 4px solid #3182ce; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .actions { display: flex; gap: 10px; }
        .btn { padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; color: white; display: inline-block; }
        .btn-primary { background-color: #3182ce; }
        .btn-danger { background-color: #e53e3e; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Mi Cuenta</h2>
        <a href="/logout" class="btn btn-danger">Cerrar Sesión</a>
    </div>

    <div class="card">
        <h3>Información del Usuario</h3>
        <p><strong>Número de Cuenta:</strong> <?= htmlspecialchars($usuario['numero_cuenta'] ?? 'N/A') ?></p>
        <p><strong>Saldo Actual:</strong> $<?= htmlspecialchars(number_format((float)($usuario['saldo'] ?? 0), 2)) ?></p>
    </div>

    <div class="actions">
        <a href="/retiro/crear" class="btn btn-primary">Realizar Retiro</a>
        <a href="/transferencia/crear" class="btn btn-primary">Realizar Transferencia</a>
    </div>
</div>

</body>
</html>