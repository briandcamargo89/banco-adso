<h3>Historial de Retiros</h3>

<?php if (empty($historial)): ?>
    <p>No se registran retiros en esta cuenta.</p>
<?php else: ?>
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 2px solid #ccc;">
                <th>Monto</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($historial as $row): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td>$<?= number_format((float)$row['valor'], 2) ?></td>
                    <td><?= e($row['fecha']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>