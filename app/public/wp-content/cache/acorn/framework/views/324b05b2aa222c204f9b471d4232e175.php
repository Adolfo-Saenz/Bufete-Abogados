




<?php echo $__env->make('partials.organisms.organism-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php if(isset($_GET['caso_id'])): ?>
  <?php echo $__env->make('partials.organisms.organism-lists', [
      'tipo' => 'events',
      'caso' => $_GET['caso_id'],
  ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php else: ?>
  <?php echo $__env->make('partials.organisms.organism-lists', [
      'tipo' => 'events',
      'caso' => '',
  ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


<?php echo $__env->make('partials.organisms.organism-footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\adolfo.saenz\Local Sites\bufete-abogados\app\public\wp-content\themes\bufete-theme\resources\views/page-events-template.blade.php ENDPATH**/ ?>