<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($siteConfig['name']); ?> <?php if (!empty(trim($__env->yieldContent('title')))): ?>&mdash;
            <?php echo $__env->yieldContent('title'); ?><?php endif; ?>
    </title>
    <meta name="description" content="Salon kecantikan dengan layanan hair styling, treatment, dan perawatan kuku.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700|cormorant-garamond:500,600i,700"
        rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="min-h-screen bg-bg text-ink antialiased">

    <?php if (!(Request::routeIs(['login', 'register']))): ?>
        <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <main>
        <?php if (session('success')): ?>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php if (!(Request::routeIs(['login', 'register']))): ?>
        <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

</body>

</html>
<?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/layouts/app.blade.php ENDPATH**/ ?>
