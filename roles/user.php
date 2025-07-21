<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'user') {
    header('Location: denied.php');
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Usuario</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }
        body {
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }
        header {
            background-color: #2e86de;
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
            font-size: 16px;
            color: #555;
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
        <h1>Hola, <?php echo $username; ?> 👤</h1>
        <p>Panel del Usuario</p>
    </header>

    <div class="dashboard">
        <div class="card">
            <h3>Mi Perfil</h3>
            <p>Accede a tu información personal y actualiza tus datos.</p>
        </div>
        <div class="card">
            <h3>Mis Actividades</h3>
            <p>Consulta el historial de sesiones, acciones o registros recientes.</p>
        </div>
        <div class="card">
            <h3>Soporte Técnico</h3>
            <p>¿Tienes algún problema? Aquí puedes contactar con el soporte.</p>
        </div>
        <div class="card">
            <h3>Información General</h3>
            <p>Consulta las normas, condiciones o novedades del sistema.</p>
        </div>
    </div>

    <a class="logout" href="logout.php">Cerrar Sesión</a>
</body>
</html>
