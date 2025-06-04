<!doctype html>
<html <?php (language_attributes()); ?>>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php (do_action('get_header')); ?>
    <?php (wp_head()); ?>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
  </head>

  <body <?php (body_class()); ?>>
    <?php (wp_body_open()); ?>

    <div id="app">
      <a class="sr-only focus:not-sr-only" href="#main">
        <?php echo e(__('Skip to content', 'sage')); ?>

      </a>

      <main id="main" class="main">
        <?php echo $__env->yieldContent('content'); ?>
      </main>

    </div>
  </body>
</html>
<?php /**PATH C:\Users\adolfo.saenz\Local Sites\bufete-abogados\app\public\wp-content\themes\bufete-theme\resources\views/layouts/app.blade.php ENDPATH**/ ?>