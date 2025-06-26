<?php require_once 'views/layout/header.php'; ?>

<h2>Lista de Clientes</h2>
<a href="index.php?action=clientes&method=add" class="btn">Agregar Cliente</a>

<table>
    <thead>
        <tr>
            <th>Cédula/RIF</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $client): ?>
        <tr>
            <td><?php echo $client['Cedula_Rif']; ?></td>
            <td><?php echo $client['Nombre']; ?></td>
            <td><?php echo $client['Apellido']; ?></td>
            <td><?php echo $client['Telefono']; ?></td>
            <td><?php echo $client['Correo']; ?></td>
            <td>
                <a href="index.php?action=clientes&method=edit&id=<?php echo $client['Cedula_Rif']; ?>">Editar</a>
                <a href="index.php?action=clientes&method=delete&id=<?php echo $client['Cedula_Rif']; ?>" 
                   onclick="return confirm('¿Estás seguro de eliminar este cliente?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once 'views/layout/footer.php'; ?>