<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = $_POST['password'];
    $role = $_POST['rol']; // "admin" o "user"

    if (strlen($username) < 4 || strlen($username) > 20) {
        $msg = "El nombre de usuario debe tener entre 4 y 20 caracteres.";
    } elseif (strlen($password) < 6) {
        $msg = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO usuarios (username, password, rol) VALUES (:username, :password, :rol)");
        $stmt->bindValue(':username', $username, SQLITE3_TEXT);
        $stmt->bindValue(':password', $hashedPassword, SQLITE3_TEXT);
        $stmt->bindValue(':rol', $role, SQLITE3_TEXT);
        $result = $stmt->execute();

        if ($result) {
            $msg = "Usuario registrado correctamente.";
        } else {
            $msg = "Error al registrar el usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #FFDEE9, #B5FFFC);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #444;
        }

        form input, form select {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        form button {
            width: 100%;
            padding: 0.75rem;
            background-color: #28A745;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
        }

        form button:hover {
            background-color: #218838;
        }

        .message {
            text-align: center;
            margin-bottom: 1rem;
            font-size: 0.95rem;
            color: #d63384;
        }

        .login-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registro</h2>
        <?php if (isset($msg)) echo "<p class='message'>$msg</p>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Nombre de usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <select name="rol">
                <option value="user">Usuario</option>
                <option value="admin">Administrador</option>
            </select>
            <button type="submit">Registrarse</button>
        </form>
        <p class="login-link">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </div>
</body>
</html>
