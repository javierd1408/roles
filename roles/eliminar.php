<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header("Location: denied.php");
    exit();
}

$db = new SQLite3(__DIR__ . '/db/database.db');

// Obtener ID del usuario a eliminar
if (!isset($_GET['id'])) {
    die("ID no especificado.");
}

$id = (int) $_GET['id'];

// Evitar que el admin actual se elimine a sí mismo
$stmt = $db->prepare("SELECT username FROM usuarios WHERE id = ?");
$stmt->bindValue(1, $id, SQLITE3_INTEGER);
$result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

if (!$result) {
    die("Usuario no encontrado.");
}

if ($result['username'] === $_SESSION['username']) {
    die("No puedes eliminar tu propio usuario.");
}

// HTML + CSS + Confirmación visual
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Eliminación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: linear-gradient(to right, #f5f7fa, #c3cfe2);
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .card {
            background-color: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 1rem;
            color: #333;
        }

        p {
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .button-group {
            display: flex;
            justify-content: space-around;
        }

        a.button {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s ease;
        }

        .confirm {
            background-color: #e74c3c;
            color: white;
        }

        .confirm:hover {
            background-color: #c0392b;
        }

        .cancel {
            background-color: #3498db;
            color: white;
        }

        .cancel:hover {
            background-color: #2980b9;
        }

        @media (max-width: 480px) {
            .button-group {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
<?php
// Confirmar eliminación si es GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['confirm'])):
?>
    <div class="card">
        <h2>Confirmar Eliminación</h2>
        <p>¿Estás seguro de que deseas eliminar al usuario <strong><?= htmlspecialchars($result['username']) ?></strong>?</p>
        <div class="button-group">
            <a href="eliminar.php?id=<?= $id ?>&confirm=1" class="button confirm">Sí, eliminar</a>
            <a href="admin.php" class="button cancel">Cancelar</a>
        </div>
    </div>
</body>
</html>
<?php
    exit();
endif;

// Eliminar si hay confirmación
if ($_GET['confirm'] == 1) {
    $stmt = $db->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bindValue(1, $id, SQLITE3_INTEGER);
    $stmt->execute();
    header("Location: admin.php");
    exit();
}
?>

