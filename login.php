<?php
session_start();
require_once __DIR__ . '/db.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$mysqli = getConnection();
$errors = [];
$success = null;
$formType = $_POST['form_type'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($formType === 'login') {
        $email = trim($_POST['login_email'] ?? '');
        $password = $_POST['login_password'] ?? '';

        if ($email === '' || $password === '') {
            $errors[] = 'Introduce un email y una contraseña.';
        } else {
            $stmt = $mysqli->prepare('SELECT id, name, password, role FROM usuario_registrado WHERE email = ? LIMIT 1');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                $stmt->bind_result($id, $name, $hash, $role);
                $stmt->fetch();
                if (password_verify($password, $hash)) {
                    $_SESSION['user_id'] = $id;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_role'] = $role;
                    header('Location: dashboard.php');
                    exit;
                }
            }
            $errors[] = 'Email o contraseña incorrectos.';
            $stmt->close();
        }
    } elseif ($formType === 'register') {
        $name = trim($_POST['register_name'] ?? '');
        $email = trim($_POST['register_email'] ?? '');
        $password = $_POST['register_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        $role = ($_POST['role'] === 'admin') ? 'admin' : 'user';

        if ($name === '' || $email === '' || $password === '' || $confirm === '') {
            $errors[] = 'Rellena todos los campos de registro.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Introduce un email válido.';
        } elseif ($password !== $confirm) {
            $errors[] = 'Las contraseñas no coinciden.';
        } elseif (strlen($password) < 6) {
            $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
        } else {
            $stmt = $mysqli->prepare('SELECT id FROM usuario_registrado WHERE email = ? LIMIT 1');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $errors[] = 'Ya existe una cuenta con ese email.';
            }
            $stmt->close();

            if (empty($errors)) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $mysqli->prepare('INSERT INTO usuario_registrado (name, email, password, role) VALUES (?, ?, ?, ?)');
                $stmt->bind_param('ssss', $name, $email, $hash, $role);
                if ($stmt->execute()) {
                    $_SESSION['user_id'] = $stmt->insert_id;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_role'] = $role;
                    header('Location: dashboard.php');
                    exit;
                }
                $errors[] = 'No se pudo crear la cuenta. Intenta de nuevo.';
                $stmt->close();
            }
        }
    }
}

function old($key) {
    return htmlspecialchars($_POST[$key] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | Diverfest</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, -apple-system, BlinkMacKit, 'Segoe UI', sans-serif; background: #fdf0d5; color: #2b2b2b; }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(216, 30, 91, 0.18), transparent 25%),
                        radial-gradient(circle at bottom right, rgba(58, 51, 53, 0.12), transparent 22%);
            pointer-events: none;
        }
        header { background: #d81e5b; padding: 18px 24px; color: white; display: flex; align-items: center; gap: 14px; }
        header h1 { margin: 0; font-size: 1.2rem; letter-spacing: .02em; }
        header p { margin: 0; opacity: .9; font-size: .95rem; }
        main { min-height: calc(100vh - 74px); padding: 24px; display: grid; place-items: center; }
        .card-grid { display: grid; gap: 24px; width: min(1100px,100%); grid-template-columns: repeat(2, minmax(280px, 1fr)); }
        .card { background: rgba(255,255,255,.96); border: 1px solid rgba(58,51,53,.08); border-radius: 24px; box-shadow: 0 22px 60px rgba(0,0,0,.08); padding: 28px; }
        .card h2 { margin: 0 0 12px; font-size: 1.4rem; }
        .card p.lead { margin: 0 0 20px; color: #5e5e66; line-height: 1.6; }
        label { display: block; margin-bottom: 8px; font-weight: 600; font-size: .95rem; }
        .field { width: 100%; margin-bottom: 16px; }
        .field input[type="text"], .field input[type="email"], .field input[type="password"], .field select { width: 100%; padding: 14px 16px; border: 1px solid rgba(58, 51, 53, .16); border-radius: 14px; font-size: 0.98rem; background: #fff; }
        .field input:focus, .field select:focus { outline: none; border-color: #d81e5b; box-shadow: 0 0 0 3px rgba(216,30,91,.12); }
        .button { width: 100%; padding: 14px 18px; border: none; border-radius: 14px; background: #d81e5b; color: white; font-size: 1rem; font-weight: 700; cursor: pointer; transition: transform .18s ease, background .18s ease; }
        .button:hover { background: #be174c; transform: translateY(-1px); }
        .note { font-size: .88rem; color: #6a6a75; margin-top: 18px; }
        .alert { border-radius: 14px; padding: 16px 18px; background: #fff1f3; border: 1px solid #f2c1cb; color: #8c1d39; margin-bottom: 20px; }
        .alert strong { display: block; margin-bottom: 6px; }
        .errors { margin-bottom: 24px; }
        .role-row { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 8px; }
        .role-row label { display: inline-flex; align-items: center; gap: 8px; font-weight: 500; margin-bottom: 0; }
        .role-row input { accent-color: #d81e5b; }
        .brand { display: inline-flex; align-items: center; gap: 10px; }
        .brand-dot { width: 12px; height: 12px; border-radius: 50%; background: #3a3335; }
        .brand-name { font-size: 1.1rem; font-weight: 700; letter-spacing: .02em; }
        .brand-path { font-size: .82rem; color: rgba(255,255,255,.88); letter-spacing: .04em; }
        .support-text { margin-top: 12px; color: #777; font-size: .92rem; }
        .grid-highlights { display: grid; gap: 12px; margin-bottom: 18px; }
        .highlight { display: inline-flex; align-items:center; gap: 10px; padding: 12px 14px; border-radius: 16px; background: #f9eef1; color: #3a3335; border: 1px solid #f2d4db; }
        .highlight::before { content: '✓'; font-weight: 700; color: #d81e5b; }
        @media (max-width: 860px) {
            .card-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header>
        <div class="brand">
            <span class="brand-dot"></span>
            <div>
                <div class="brand-name">Diverfest</div>
                <div class="brand-path">diverfest.es/inicio</div>
            </div>
        </div>
        <p>Bienvenido. Inicia sesión o crea una cuenta nueva con tu perfil de administrador o usuario registrado.</p>
    </header>
    <main>
        <div class="card-grid">
            <section class="card">
                <h2>Iniciar sesión</h2>
                <p class="lead">Accede con tu email y contraseña. Si eres administrador, selecciona ese rol al registrarte.</p>
                <?php if (!empty($errors) && $formType === 'login'): ?>
                    <div class="alert">
                        <strong>Errores:</strong>
                        <?php foreach ($errors as $error): ?>
                            <div><?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="login.php">
                    <input type="hidden" name="form_type" value="login">
                    <div class="field">
                        <label for="email-login">Email</label>
                        <input id="email-login" type="email" name="login_email" value="<?= old('login_email') ?>" placeholder="tu@correo.com" required>
                    </div>
                    <div class="field">
                        <label for="password-login">Contraseña</label>
                        <input id="password-login" type="password" name="login_password" placeholder="********" required>
                    </div>
                    <button class="button" type="submit">Entrar</button>
                </form>
                <p class="note">Si no tienes cuenta, usa el formulario de registro de la derecha.</p>
            </section>
            <section class="card">
                <h2>Crear cuenta nueva</h2>
                <div class="grid-highlights">
                    <span class="highlight">Contraseña segura con hash</span>
                    <span class="highlight">Rol administrativo o usuario</span>
                    <span class="highlight">Datos guardados en MySQL / phpMyAdmin</span>
                </div>
                <?php if (!empty($errors) && $formType === 'register'): ?>
                    <div class="alert">
                        <strong>Errores:</strong>
                        <?php foreach ($errors as $error): ?>
                            <div><?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="login.php">
                    <input type="hidden" name="form_type" value="register">
                    <div class="field">
                        <label for="name-register">Nombre</label>
                        <input id="name-register" type="text" name="register_name" value="<?= old('register_name') ?>" placeholder="Tu nombre" required>
                    </div>
                    <div class="field">
                        <label for="email-register">Email</label>
                        <input id="email-register" type="email" name="register_email" value="<?= old('register_email') ?>" placeholder="tu@correo.com" required>
                    </div>
                    <div class="field">
                        <label for="password-register">Contraseña</label>
                        <input id="password-register" type="password" name="register_password" placeholder="Mínimo 6 caracteres" required>
                    </div>
                    <div class="field">
                        <label for="confirm_password">Confirmar contraseña</label>
                        <input id="confirm_password" type="password" name="confirm_password" placeholder="Repite tu contraseña" required>
                    </div>
                    <div class="field">
                        <label>Selecciona tu rol</label>
                        <div class="role-row">
                            <label><input type="radio" name="role" value="user" checked> Usuario registrado</label>
                            <label><input type="radio" name="role" value="admin"> Administrador</label>
                        </div>
                    </div>
                    <button class="button" type="submit">Crear cuenta</button>
                </form>
                <p class="note">La información se almacena en la base de datos MySQL que administra phpMyAdmin.</p>
            </section>
        </div>
    </main>
</body>
</html>
