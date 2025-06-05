



<?php
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $user_name = $user->user_nicename;
    $role = $user->roles[0];

    $city = get_field('city', 'user_' . $user_id);
    $country = get_field('country', 'user_' . $user_id);
    $profile_image = get_field('profile-image', 'user_' . $user_id);
?>


<?php echo $__env->make('partials.organisms.organism-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<section class="relative lg:h-[500px] h-responsive text-[#232536] bg-[#6A6B75] flex max-md:flex max-md:flex-col max-md:justify-center max-md:gap-2 w-full">
    <div class="lg:h-[500px] w-full md:w-3/5 h-responsive max-lg:mt-10">
        <div class="flex lg:flex-row flex-col items-center lg:ml-10 lg:my-25">
            <?php if($profile_image != ""): ?>
                <img src="<?php echo e($profile_image); ?>" alt="Tu imagen de perfil" class="w-[300px] h-[300px] rounded-full">
            <?php else: ?>
                <img src="http://bufete-abogados.local/wp-content/uploads/2025/06/default.png" alt="Tu imagen de perfil" class="w-[300px] h-[300px] rounded-full">
            <?php endif; ?>
            <div class="max-lg:flex max-lg:flex-col max-lg:items-center max-lg:text-center">
                <p class="max-sm:text-[40px] text-[50px] leading-22 font-bold h-responsive lg:pl-12 max-lg:px-4">
                    <?php echo e($user_name); ?>

                </p>
                <p class="text-[25px] max-sm:text-[20px] leading-6 lg:pl-12 px-4 lg:[width:600px] w-full h-responsive">
                    <?php if($city != ""): ?>
                        <?php if($country != ""): ?>
                            <?php echo e($city); ?>, <?php echo e($country); ?>

                        <?php endif; ?>
                        <?php echo e($city); ?>, Pais no registrado
                    <?php else: ?>
                        <?php if($country != ""): ?>
                            Ciudad no registrada, <?php echo e($country); ?>

                        <?php endif; ?>
                        No hay datos de localidades
                    <?php endif; ?>
                </p>
                <a href="<?php echo e("#"); ?>" class="boton text-[20px] lg:ml-12 mt-10 lg:mb-0 mb-7 [width:186px] [height:65px] flex items-center justify-center bg-white text-[#232536] rounded-[10px] font-bold font-sans hover:scale-105 transition-transform duration-200">
                    Editar perfil
                </a>
            </div>
        </div>
    </div>
    <div class="lg:h-[500px] bg-red-600 h-responsive md:w-2/5 bg-cover flex items-center justify-center">
        <div class="w-full h-100 font-bold text-[85px]">
            <h1>Calendar</h1>
        </div>
    </div>
</section>


<?php echo $__env->make('partials.organisms.organism-cards', [
    'tipo' => 'Case'
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php echo $__env->make('partials.organisms.organism-footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\adolfo.saenz\Local Sites\bufete-abogados\app\public\wp-content\themes\bufete-theme\resources\views/page-users.blade.php ENDPATH**/ ?>