<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Error</title>
    <!-- Optimizado: cargar solo los componentes necesarios de Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/fontawesome.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/solid.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #6366f1;
            --text-color: #4b5563;
            --light-text: #9ca3af;
            --background: #f9fafb;
            --card-bg: #ffffff;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --gradient: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            --gradient-bg: linear-gradient(135deg, rgba(79, 70, 229, 0.1), rgba(99, 102, 241, 0.1));
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            height: 100%;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            overflow-x: hidden;
        }

        .error-container {
            width: 100%;
            max-width: 1000px;
            background-color: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            position: relative;
            justify-content: center;
        }

        .error-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem;
            max-height: calc(100vh - 2rem);
            justify-content: center;
        }

        .error-message {
            flex: 1;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            justify-content: center;
            position: relative;
            z-index: 2;
            justify-content: center;    
        }

        .error-code {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 1rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
        }

        .error-code::after {
            content: "";
            position: absolute;
            height: 4px;
            width: 60px;
            background: var(--gradient);
            bottom: -0.5rem;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .error-text {
            font-size: 1.25rem;
            color: var(--text-color);
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .btn-home {
            background: var(--gradient);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .btn-home:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }

        .btn-home i {
            margin-right: 0.5rem;
        }

        .error-logo {
            max-width: 180px;
            margin-top: 1rem;
        }

        .error-logo img {
            width: 100%;
            height: auto;
        }

        .error-image {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        .error-image img {
            width: 100%;
            height: auto;
            border-radius: 12px;
            transition: transform 0.3s ease;
            object-fit: contain;
            display: block;
        }

        .background-decoration {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: var(--gradient-bg);
            z-index: 1;
        }

        .background-decoration:first-child {
            top: -100px;
            right: -100px;
        }

        .background-decoration:last-child {
            left: -100px;
            bottom: -100px;
            top: auto;
            right: auto;
        }

        /* ===== Media Queries Optimizados ===== */
        
        /* Teléfonos pequeños (hasta 375px) */
        @media (max-width: 375px) {
            body {
                padding: 0;
            }
            
            .error-content {
                padding: 0.75rem;
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
            }
            
            .error-content {
                padding: 0.75rem;
                height: 100%;
                justify-content: center;
            }
            
            .error-message {
                padding: 0.5rem;
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
            
            .error-code {
                text-align: center;
                width: 100%;
            }
            
            .error-text {
                font-size: 1rem;
            }
            
            .error-logo {
                margin-top: 2rem;
                width: 120px;
            }
            
            .btn-home {
                margin: 1.5rem auto;
            }
            .btn-home {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }
            
            .error-image {
                display: none;
            }
        }
        
        /* Teléfonos medianos (376px - 575px) */
        @media (min-width: 376px) and (max-width: 575px) {
            body {
                padding: 0;
            }
            
            .error-content {
                padding: 1rem;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            
            .error-message {
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
            }
            
            .error-code {
                text-align: center;
                width: 100%;
            }
            
            .error-logo {
                margin-top: 2rem;
                width: 150px;
            }
            
            .btn-home {
                margin: 1.5rem auto;
            }

            .error-text {
                font-size: 1.1rem;
            }
            
            .error-image {
                display: none;
            }
        }
        
        /* Tablets pequeñas (576px - 767px) */
        @media (min-width: 576px) and (max-width: 767px) {
            .error-container {
                width: 95%;
                max-width: 95%;
                margin: 1rem;
            }
            
            .error-content {
                padding: 2rem;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
            }
            
            .error-message {
                width: 100%;
                padding: 1rem;
                margin-bottom: 1.5rem;
            }

            .error-code {
                font-size: 3.2rem;
                margin-bottom: 1rem;
            }
                   
            .error-text {
                font-size: 1.2rem;
                margin-bottom: 1.5rem;
            }

            .error-logo {
                width: 160px;
                margin: 1.5rem auto;
            }

            .btn-home {
                margin: 1rem auto;
                padding: 0.75rem 1.5rem;
            }

            .error-image {
                width: 100%;
                max-width: 400px;
                margin: 0 auto;
                padding: 1rem;
            }
            
            .error-image img {
                width: 100%;
                height: auto;
                max-width: 350px;
                margin: 0 auto;
                display: block;
            }
        }
        
        /* Tablets y pantallas medianas (768px - 991px) */
        @media (min-width: 768px) and (max-width: 991px) {
            .error-content {
                flex-direction: row;
                align-items: stretch;
                padding: 1.5rem;
            }
            
            .error-message {
                text-align: left;
                align-items: flex-start;
                padding: 1.5rem;
                flex: 1;
            }
            
            .error-code {
                font-size: 4rem;
            }
            
            .error-code::after {
                left: 0;
                transform: none;
            }
            
            .error-text {
                font-size: 1.4rem;
            }
            
            .error-image {
                flex: 1;
                padding: 1.5rem;
                display: flex;
                justify-content: center;
                align-items: center;
                max-width: 50%;
            }
            
            .error-image img {
                width: 100%;
                max-width: 100%;
            }
        }
        
        /* Pantallas medianas (992px - 1199px) */
        @media (min-width: 992px) and (max-width: 1199px) {
            .error-content {
                flex-direction: row;
                align-items: center;
                padding: 2rem;
            }
            
            .error-message {
                text-align: left;
                align-items: flex-start;
                padding: 2rem;
                flex: 1;
            }
            
            .error-code {
                font-size: 4.2rem;
            }
            
            .error-code::after {
                left: 0;
                transform: none;
            }
            
            .error-text {
                font-size: 1.5rem;
            }
            
            .error-image {
                flex: 1;
                display: flex;
                justify-content: center;
                max-width: 50%;
            }
            
            .error-image img {
                width: 100%;
                max-width: 100%;
            }
        }
        
        /* Pantallas grandes (1200px y superiores) */
        @media (min-width: 1200px) {
            .error-content {
                flex-direction: row;
                align-items: center;
                padding: 2.5rem;
            }
            
            .error-message {
                text-align: left;
                align-items: flex-start;
                padding: 2.5rem;
                flex: 1;
            }
            
            .error-code {
                font-size: 5rem;
            }
            
            .error-code::after {
                left: 0;
                transform: none;
                height: 6px;
                width: 80px;
            }
            
            .error-text {
                font-size: 1.6rem;
            }
            
            .error-image {
                flex: 1;
                max-width: 50%;
                display: flex;
                justify-content: center;
            }
            
            .error-image img {
                width: 100%;
                max-width: 100%;
            }
        }
        /* Teléfonos en modo paisaje */
        @media (max-height: 500px) and (orientation: landscape) {
            body {
                padding: 0.5rem;
                align-items: flex-start;
            }
            
            .error-container {
                margin: 0.5rem auto;
                max-height: calc(100vh - 1rem);
            }
            
            .error-content {
                flex-direction: row;
                padding: 1rem;
                gap: 1rem;
            }
            
            .error-message {
                padding: 0.5rem;
                margin: 0;
                flex: 1;
            }
            
            .error-code {
                font-size: 2.5rem;
                margin-bottom: 0.5rem;
            }
            
            .error-text {
                font-size: 1rem;
                margin-bottom: 0.5rem;
            }
            
            .error-logo {
                width: 100px;
                margin-top: 0.5rem;
            }
            
            .btn-home {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
                margin: 0.5rem 0;
            }
            
            .error-image {
                display: none;
            }
            
            .background-decoration {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="background-decoration"></div>
        <div class="background-decoration"></div>

        <div class="error-content">
            <div class="error-message">
                <div class="error-code"><?php echo $__env->yieldContent('code'); ?></div>
                <div class="error-text"><?php echo $__env->yieldContent('message'); ?></div>
                <a href="/login" class="btn-home">
                    <i class="fas fa-home"></i> Volver a Home
                </a>
                <div class="error-logo">
                    <img src="<?php echo e(asset('img/agiledesk.png')); ?>" alt="Logo" loading="lazy">
                </div>
            </div>
            <div class="error-image">
                <img src="<?php echo e(asset('img/errores/escritorio.png')); ?>" alt="Ilustración de error" loading="lazy">
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\Dell\Herd\AgileDesk\resources\views/errors/minimal.blade.php ENDPATH**/ ?>