<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Laravel')); ?> - Esperando Aprobación</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            height: 100%;
            overflow-x: hidden;
            max-width: 100vw;
        }
        
        .pending-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #62b0f0;
            padding: 1rem;
            width: 100%;
        }
        
        .pending-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem 1.5rem;
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        
        .pending-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            color: #4dd0b4;
        }
        
        .pending-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2d3a4d;
            margin-bottom: 1rem;
        }
        
        .pending-message {
            color: #555;
            margin-bottom: 1.5rem;
            line-height: 1.6;
            font-size: 0.9rem;
        }
        
        .back-button {
            background-color: #4dd0b4;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 0.75rem 2rem;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
            width: 100%;
        }
        
        .back-button:hover {
            background-color: #3db9a1;
        }
        /* Standard Desktop */
        @media (min-width: 992px) and (max-width: 1399px) {
            .pending-card {
                max-width: 550px;
                padding: 2.75rem;
            }
            
            .pending-icon {
                width: 110px;
                height: 110px;
            }
        }
        /* Medium devices (tablets, 768px and up) */
        @media (min-width: 768px) {
            .pending-card {
                padding: 2.5rem;
            }
            
            .pending-icon {
                width: 100px;
                height: 100px;
                margin-bottom: 2rem;
            }
            
            .pending-title {
                font-size: 1.5rem;
            }
            
            .pending-message {
                font-size: 1rem;
                margin-bottom: 2rem;
            }
            
            .back-button {
                width: auto;
            }
        }
        
        /* Small devices (landscape phones, 576px and up) */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .pending-card {
                max-width: 450px;
            }
            
            .pending-icon {
                width: 90px;
                height: 90px;
            }
        }
        
        /* Extra small devices (portrait phones, less than 576px) */
        @media (max-width: 575.98px) {
            .pending-container {
                padding: 1rem;
            }
            
            .pending-card {
                padding: 1.5rem 1rem;
                border-radius: 4px;
            }
        }
        /* Foldable Devices - Folded */
    @media (max-width: 320px) {
        .pending-container {
            padding: 0.5rem;
        }
        
        .pending-card {
            padding: 1rem;
        }
        
        .pending-icon {
            width: 50px;
            height: 50px;
            margin-bottom: 1rem;
        }
        
        .pending-title {
            font-size: 1.1rem;
        }
        
        .pending-message {
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }
        
        .back-button {
            padding: 0.5rem 1rem;
        }
    }
    </style>
</head>
<body>
    <div class="pending-container">
        <div class="pending-card">
            <div class="pending-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <h1 class="pending-title">Registro Pendiente de Aprobación</h1>
            <p class="pending-message">
                Gracias por registrarte. Tu cuenta está pendiente de aprobación por parte del administrador. 
                Te notificaremos por correo electrónico cuando tu cuenta haya sido aprobada.
            </p>
            <a href="<?php echo e(route('login')); ?>" class="back-button">
                Volver al inicio de sesión
            </a>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\gutya\Desktop\AgileDesk\resources\views/pendiente.blade.php ENDPATH**/ ?>