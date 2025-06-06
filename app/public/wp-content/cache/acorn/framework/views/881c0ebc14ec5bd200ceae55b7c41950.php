
<?php
    /* Obtenemos las categorías de Wordpress */
    $categorias = get_categories([
        'hide_empty' => false, // mostrar también las vacías
        'number' => 4,
    ]);

    $args = [
    'post_type' => 'caso',
    'posts_per_page' => 4,
    ];

    $query = new WP_Query($args);

    $user = wp_get_current_user();
    $user_id = $user->ID;
?>

<?php if($tipo == "Espec"): ?>
    
    <section class="px-6 py-10">
    <div class="grid grid-cols-1 gap-2 lg:grid-cols-[1fr_auto] items-center mb-3">
        <div class="flex items-center space-x-2">
        <h3 class="font-bold text-[25px]">Nuestras especializaciones</h3>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
        </svg>  
        </div>
        <a href="#" class="text-[16px] w-[70px] h-[25px]">Ver todo</a>
    </div>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $image_url = get_field('category-pic', 'term_' . $categoria->term_id);
        ?>
        <div class="h-responsive bg-gray-200 border-0 rounded-[15px] flex flex-col justify-center gap-2">
            <div class="m-4 flex justify-center">
            <img src="<?php echo e($image_url); ?>" alt="<?php echo e($categoria->name); ?>" class="h-[150px] border-0 rounded-[10px]">
            </div>
            <div class="mr-4 ml-4">
            <a href="#" class="text-[18px] font-bold">
                <?php echo e($categoria->name); ?>

            </a>
            </div>
            <div class="m-4">
            <?php echo e($categoria->description); ?>

            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    </section>
<?php else: ?>
    
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

                    $lawyer_id = get_field('lawyer', $caso->ID);
                    $lawyer_user = get_userdata($lawyer_id);
                    $lawyer_name = $lawyer_user ? $lawyer_user->display_name : 'Cliente desconocido';
                ?>
                <?php if($client_id == $user_id || $lawyer_id == $user_id): ?>
                    <div class="h-responsive bg-gray-200 border-0 rounded-[15px] flex flex-col justify-center gap-2 mb-6">
                        <div class="m-4 flex justify-center">
                            <img src="<?php echo e($image_url); ?>" alt="Imagen tipo caso" class="h-[150px] border-0 rounded-[10px] object-cover">
                        </div>
                        <div class="mr-4 ml-4">
                            <h3 class="text-[18px] font-bold mb-1"><?php echo e($caso->post_title); ?></h3>
                            <p><strong>Cliente:</strong> <?php echo e($client_name); ?></p>
                            <p><strong>Abogado(s):</strong> <?php echo e($lawyer_name); ?></p>
                        </div>
                        <div class="m-4">
                            <a href="<?php echo e($caso->guid); ?>" class="inline-block hover:bg-[#767CB5] bg-[#6A6B75] text-white px-4 py-2 rounded transition">
                                Leer caso
                            </a>
                        </div>
                    </div>
                <?php endif; ?> 
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
<?php endif; ?><?php /**PATH C:\Users\adolfo.saenz\Local Sites\bufete-abogados\app\public\wp-content\themes\bufete-theme\resources\views/partials/organisms/organism-cards.blade.php ENDPATH**/ ?>