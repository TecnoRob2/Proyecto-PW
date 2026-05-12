<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$name = htmlspecialchars($_SESSION['user_name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$role = $_SESSION['user_role'] === 'admin' ? 'Administrador' : 'Usuario registrado';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel | Diverfest</title>
    <style>
        body { margin: 0; font-family: system-ui, sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #fdf0d5 0%, #ffd7e2 100%); color: #2b2b2b; }
        .panel { width: min(760px, 100%); padding: 32px; background: white; border-radius: 24px; box-shadow: 0 24px 48px rgba(0,0,0,.12); }
        h1 { margin-top: 0; }
        .badge { display: inline-flex; background: #d81e5b; color: white; border-radius: 999px; padding: 8px 16px; font-size: .95rem; margin-top: 12px; }
        .button { display: inline-block; margin-top: 28px; padding: 14px 22px; border-radius: 14px; border: none; background: #3a3335; color: white; text-decoration: none; font-weight: 700; }
        .section { margin-top: 24px; line-height: 1.7; }
    </style>
</head>
<body>
    <main class="panel">
        <h1>Bienvenido, <?= $name ?></h1>
        <span class="badge"><?= $role ?></span>
        <div class="section">
            <p>Has iniciado sesión correctamente. Tu cuenta está guardada en la base de datos MySQL de phpMyAdmin.</p>
            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <p>Como administrador puedes acceder a las secciones privadas y gestionar configuraciones internas.</p>
            <?php else: ?>
                <p>Eres un usuario registrado. Navega por los contenidos y actividades de Diverfest.</p>
            <?php endif; ?>
        </div>
        <a class="button" href="logout.php">Cerrar sesión</a>
    </main>
</body>
</html>
