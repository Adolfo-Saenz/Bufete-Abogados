



<?php
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $user_name = $user->user_nicename;
    $role = $user->roles[0];

    $city = get_field('city', 'user_' . $user_id);
    $country = get_field('country', 'user_' . $user_id);
    $profile_image = get_field('profile-image', 'user_' . $user_id);

    $args = [
    'post_type' => 'caso',
    'posts_per_page' => -1,
    ];

    $query = new WP_Query($args);
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
                    <?php echo e($city); ?>, 
                    <?php echo e($country); ?>

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


<section class="px-6 py-10">
    <div class="grid grid-cols-1 gap-2 lg:grid-cols-[1fr_auto] items-center mb-3">
        <div class="flex items-center space-x-2">
            <h3 class="font-bold text-[25px]">Casos</h3>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
            </svg>  
        </div>
        <a href="#" class="text-[16px] w-[70px] h-[25px]">Ver todos</a>
    </div>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php $__currentLoopData = $query->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $tipo_caso_id = get_field('type', $caso->ID);
                $image_url = $tipo_caso_id ? get_field('category-pic', 'term_' . $tipo_caso_id) : null;

                $client_id = get_field('client', $caso->ID);
                $client_user = get_userdata($client_id);
                $client_name = $client_user ? $client_user->display_name : 'Cliente desconocido';

                $lawyers = get_field('lawyers', $caso->ID);
                $lawyers_names = [];

                if ($lawyers) {
                    foreach ($lawyers as $lawyer) {
                        if (isset($lawyer['lawyer'])) {
                            $lawyer_user = get_userdata($lawyer['lawyer']);
                            if ($lawyer_user) {
                                $lawyers_names[] = $lawyer_user->display_name;
                            }
                        }
                    }
                }
            ?>

            <div class="h-responsive bg-gray-200 border-0 rounded-[15px] flex flex-col justify-center gap-2 mb-6">
                <div class="m-4 flex justify-center">
                    <img src="<?php echo e($image_url); ?>" alt="Imagen tipo caso" class="h-[150px] border-0 rounded-[10px] object-cover">
                </div>
                <div class="mr-4 ml-4">
                    <h3 class="text-[18px] font-bold mb-1"><?php echo e($caso->post_title); ?></h3>
                    <p><strong>Cliente:</strong> <?php echo e($client_name); ?></p>
                    <p><strong>Abogado(s):</strong> <?php echo e(implode(', ', $lawyers_names) ?: 'Sin abogado asignado'); ?></p>
                </div>
                <div class="m-4">
                    <a href="<?php echo e(get_permalink($caso->ID)); ?>" class="inline-block hover:bg-[#767CB5] bg-[#6A6B75] text-white px-4 py-2 rounded transition">
                        Leer caso
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>


<?php echo $__env->make('partials.organisms.organism-footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\adolfo.saenz\Local Sites\bufete-abogados\app\public\wp-content\themes\bufete-theme\resources\views/page-users.blade.php ENDPATH**/ ?>