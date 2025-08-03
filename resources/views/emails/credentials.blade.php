<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Credenciales de acceso</title>
</head>
<body>
    <h2>Bienvenido/a</h2>
    <p>Estas son tus credenciales para acceder al sistema:</p>
    <ul>
        <li><strong>Email:</strong> {{ $email }}</li>
        <li><strong>Contraseña:</strong> {{ $password }}</li>
    </ul>
    <p>Por favor, guarda esta información en un lugar seguro.</p>
    <p>Saludos,</p>
    <p>El equipo de soporte</p>
</body>
</html>
