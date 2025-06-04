<article <?php (post_class()); ?>>
  <header>
    <h2 class="entry-title">
      <a href="<?php echo e(get_permalink()); ?>">
        <?php echo $title; ?>

      </a>
    </h2>

    <?php echo $__env->make('partials.entry-meta', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  </header>

  <div class="entry-summary">
    <?php (the_excerpt()); ?>
  </div>
</article>
<?php /**PATH C:\Users\adolfo.saenz\Local Sites\bufete-abogados\app\public\wp-content\themes\bufete-theme\resources\views/partials/content.blade.php ENDPATH**/ ?>