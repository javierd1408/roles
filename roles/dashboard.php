<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['rol'])) {
    header('Location: login.php');
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Usuario</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #4b6cb7, #182848);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }
        .panel {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            width: 90%;
            max-width: 400px;
        }
        h1 {
            font-size: 24px;
        }
        .rol {
            font-weight: bold;
            color: #ffd700;
        }
        a.logout {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: crimson;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        a.logout:hover {
            background-color: #b30000;
        }
        a.btn-panel {
        display: inline-block;
        margin-top: 15px;
        padding: 10px 20px;
        background-color: #00c8ff;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        transition: background-color 0.3s ease;
}
        a.btn-panel:hover {
        background-color: #009ecf;
}

    </style>
</head>
<body>
    <div class="panel">
        <h1>¡Hola, <span class="rol"><?php echo $username; ?></span>!</h1>
        <p>Has iniciado sesión como <strong class="rol"><?php echo $rol === 'admin' ? 'Administrador' : 'Usuario'; ?></strong>.</p>

        <?php if ($rol === 'admin'): ?>
            <p>Accede al panel de control administrativo.</p>
            <a class="btn-panel" href="admin.php">Ir al Panel de Administrador</a>
        <?php else: ?>
            <p>Bienvenido al área de usuario regular.</p>
            <a class="btn-panel" href="user.php">Ir al Panel de Usuario</a>
        <?php endif; ?>

        <a class="logout" href="logout.php">Cerrar sesión</a>
    </div>
</body>
</html>
