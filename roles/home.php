<?php
session_start();
$loggedIn = isset($_SESSION['username'], $_SESSION['rol']);
$username = $loggedIn ? htmlspecialchars($_SESSION['username']) : null;
$rol = $loggedIn ? $_SESSION['rol'] : null;
$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Inicio | Sistema de Roles</title>
<style>
    body {
        margin:0; padding:0;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg,#c3ec52,#0ba29d);
        min-height:100vh;
        display:flex;
        justify-content:center;
        align-items:center;
    }
    .card {
        background:#fff;
        padding:2rem;
        border-radius:16px;
        box-shadow:0 8px 24px rgba(0,0,0,.15);
        max-width:420px;
        width:90%;
        text-align:center;
    }
    h1{margin-bottom:1rem;color:#333;font-size:1.5rem;}
    p{margin-bottom:1.5rem;color:#555;}
    .btn{
        display:inline-block;
        margin:.25rem;
        padding:.75rem 1.25rem;
        border-radius:8px;
        border:none;
        text-decoration:none;
        font-size:1rem;
        cursor:pointer;
        transition:.2s;
    }
    .btn-login{background:#4a90e2;color:#fff;}
    .btn-login:hover{background:#357ABD;}
    .btn-register{background:#28a745;color:#fff;}
    .btn-register:hover{background:#218838;}
    .btn-dashboard{background:#ffb100;color:#000;}
    .btn-dashboard:hover{background:#e6a002;}
    .msg{margin-bottom:1rem;font-size:.95rem;color:#d63384;}
    .rol{font-weight:bold;color:#ff6600;}
</style>
</head>
<body>
<div class="card">
    <?php if ($msg === 'sesion_cerrada'): ?>
        <p class="msg">Sesión cerrada correctamente.</p>
    <?php endif; ?>

    <?php if ($loggedIn): ?>
        <h1>Hola, <?php echo $username; ?> 👋</h1>
        <p>Ingresaste como <span class="rol"><?php echo $rol === 'admin' ? 'Administrador' : 'Usuario'; ?></span>.</p>
        <a class="btn btn-dashboard" href="dashboard.php">Ir al Panel</a>
        <a class="btn btn-login" href="logout.php">Cerrar sesión</a>
    <?php else: ?>
        <h1>Sistema de Control de Roles</h1>
        <p>Inicia sesión o crea una cuenta para continuar.</p>
        <a class="btn btn-login" href="login.php">Iniciar Sesión</a>
        <a class="btn btn-register" href="register.php">Registrarse</a>
    <?php endif; ?>
</div>
</body>
</html>