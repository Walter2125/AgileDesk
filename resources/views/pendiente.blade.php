<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1>Solicitud enviada</h1>
        </div>
        <div class="card-body">
            <p>Gracias por registrarte. Tu cuenta está pendiente de aprobación por un administrador.</p>
            <p>Te notificaremos por correo cuando tu cuenta sea aprobada y podrás iniciar sesión.</p>
            <a href="{{ route('login') }}" class="btn btn-primary">Volver al inicio de sesión</a>
        </div>
    </div>
</div>
</body>
</html>