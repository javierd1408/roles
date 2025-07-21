<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header('Location: denied.php');
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
$db = new SQLite3(__DIR__ . '/db/database.db');

// Obtener estadísticas reales
$totalUsuarios = $db->querySingle("SELECT COUNT(*) FROM usuarios");
$totalAdmins = $db->querySingle("SELECT COUNT(*) FROM usuarios WHERE rol = 'admin'");
$totalRegulares = $db->querySingle("SELECT COUNT(*) FROM usuarios WHERE rol = 'user'");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }
        body {
            margin: 0;
            padding: 0;
            background: #f1f2f7;
        }
        header {
            background-color: #34495e;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .dashboard {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 30px;
            justify-content: center;
        }
        .card {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            flex: 1 1 250px;
            max-width: 300px;
            text-align: center;
            transition: transform 0.2s ease;
        }
        .card:hover {
            transform: scale(1.03);
        }
        .card h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #2c3e50;
        }
        .card p {
            font-size: 28px;
            color: #2980b9;
        }
        .logout {
            display: block;
            margin: 30px auto;
            padding: 10px 20px;
            width: fit-content;
            background-color: #c0392b;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            text-align: center;
        }
        .logout:hover {
            background-color: #a93226;
        }
        @media screen and (max-width: 600px) {
            .dashboard {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Bienvenido, <?php echo $username; ?> 👨‍💼</h1>
        <p>Panel de Administración</p>
    </header>

    <div class="dashboard">
        <div class="card">
            <h3>Total de Usuarios</h3>
            <p><?php echo $totalUsuarios; ?></p>
        </div>
        <div class="card">
            <h3>Administradores</h3>
            <p><?php echo $totalAdmins; ?></p>
        </div>
        <div class="card">
            <h3>Usuarios Regulares</h3>
            <p><?php echo $totalRegulares; ?></p>
        </div>
    </div>
<?php
// Obtener todos los usuarios
$resultado = $db->query("SELECT id, username, rol FROM usuarios");
?>

<div style="padding: 30px;">
    <h2 style="text-align:center;">📋 Lista de Usuarios</h2>
    <table style="width: 100%; border-collapse: collapse; background-color: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <thead style="background-color: #2980b9; color: white;">
            <tr>
                <th style="padding: 12px;">ID</th>
                <th style="padding: 12px;">Usuario</th>
                <th style="padding: 12px;">Rol</th>
                <th style="padding: 12px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fila = $resultado->fetchArray(SQLITE3_ASSOC)): ?>
                <tr style="border-bottom: 1px solid #ccc;">
                    <td style="padding: 12px; text-align:center;"><?php echo $fila['id']; ?></td>
                    <td style="padding: 12px;"><?php echo htmlspecialchars($fila['username']); ?></td>
                    <td style="padding: 12px; text-align:center;"><?php echo $fila['rol']; ?></td>
                    <td style="padding: 12px; text-align:center;">
                        <a href="editar.php?id=<?php echo $fila['id']; ?>" style="background-color: #f39c12; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none;">Editar</a>
                        <?php if ($fila['username'] !== $username): ?>
                            <a href="eliminar.php?id=<?php echo $fila['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');" style="background-color: #e74c3c; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; margin-left: 10px;">Eliminar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
    <a class="logout" href="logout.php">Cerrar Sesión</a>
</body>
</html>