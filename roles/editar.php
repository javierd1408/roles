<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header("Location: denied.php");
    exit();
}

$db = new SQLite3(__DIR__ . '/db/database.db');

// Obtener ID del usuario
if (!isset($_GET['id'])) {
    die("ID de usuario no proporcionado.");
}
$id = (int) $_GET['id'];

// Procesar formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevoUsuario = $_POST['username'];
    $nuevoRol = $_POST['rol'];
    $nuevaPass = $_POST['password'];

    // Validación básica
    if (!in_array($nuevoRol, ['admin', 'user'])) {
        die("Rol no válido.");
    }

    // Si hay nueva contraseña, actualizarla con hash
    if (!empty($nuevaPass)) {
        $hashedPass = password_hash($nuevaPass, PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE usuarios SET username = ?, rol = ?, password = ? WHERE id = ?");
        $stmt->bindValue(1, $nuevoUsuario, SQLITE3_TEXT);
        $stmt->bindValue(2, $nuevoRol, SQLITE3_TEXT);
        $stmt->bindValue(3, $hashedPass, SQLITE3_TEXT);
        $stmt->bindValue(4, $id, SQLITE3_INTEGER);
    } else {
        // No se cambia contraseña
        $stmt = $db->prepare("UPDATE usuarios SET username = ?, rol = ? WHERE id = ?");
        $stmt->bindValue(1, $nuevoUsuario, SQLITE3_TEXT);
        $stmt->bindValue(2, $nuevoRol, SQLITE3_TEXT);
        $stmt->bindValue(3, $id, SQLITE3_INTEGER);
    }

    if ($stmt->execute()) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error al actualizar.";
    }
}

// Obtener datos actuales del usuario
$stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bindValue(1, $id, SQLITE3_INTEGER);
$result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

if (!$result) {
    die("Usuario no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #e8ecf0;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 1.8em;
            color: #333;
            text-align: center;
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
            color: #333;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px 14px;
            margin-top: 8px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 1rem;
            transition: border 0.3s ease;
        }

        input:focus,
        select:focus {
            border-color: #3498db;
            outline: none;
        }

        button {
            width: 100%;
            background-color: #3498db;
            color: white;
            padding: 12px;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        @media (max-width: 500px) {
            form {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <form method="post">
        <h2>Editar Usuario</h2>
        <label>Nombre de usuario:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($result['username']); ?>" required>

        <label>Rol:</label>
        <select name="rol">
            <option value="admin" <?php echo $result['rol'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
            <option value="user" <?php echo $result['rol'] === 'user' ? 'selected' : ''; ?>>Usuario</option>
        </select>

        <label>Nueva contraseña (dejar en blanco si no se cambia):</label>
        <input type="password" name="password" placeholder="Opcional">

        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
