


<?php
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $perfil = $user->roles;

    $tipo_caso_id = get_field('type');
    $image_url = $tipo_caso_id ? get_field('category-pic', 'term_' . $tipo_caso_id) : null;

    $client_id = get_field('client');
    $client_user = get_userdata($client_id);
    $client_name = $client_user ? $client_user->display_name : 'Cliente desconocido';

    $lawyer_id = get_field('lawyer');
    $lawyer_user = get_userdata($lawyer_id);
    $lawyer_name = $lawyer_user ? $lawyer_user->display_name : 'Abogado desconocido';

    $estado = get_field('status');

    $fecha_inicio = get_field('starting-date');

    $desc = get_field('desc');

    $argsEventos = [
        'post_type' => 'evento',
    ];
    $eventos = new WP_Query($argsEventos);
?>

<head>
    <!-- jsCalendar v1.4.5 Javascript and CSS from unpkg cdn -->
    <script src="https://unpkg.com/simple-jscalendar@1.4.5/source/jsCalendar.min.js" integrity="sha384-F3Wc9EgweCL3C58eDn9902kdEH6bTDL9iW2JgwQxJYUIeudwhm4Wu9JhTkKJUtIJ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/simple-jscalendar@1.4.5/source/jsCalendar.min.css" integrity="sha384-CTBW6RKuDwU/TWFl2qLavDqLuZtBzcGxBXY8WvQ0lShXglO/DsUvGkXza+6QTxs0" crossorigin="anonymous">
    <!-- Load spanish language -->
    <script type="text/javascript" src="jsCalendar.lang.es.js"></script>
</head>


<?php echo $__env->make('partials.organisms.organism-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php if($client_id == $user_id || $lawyer_id == $user_id || $perfil[0] == 'administrator'): ?>
    
    <section class="px-10 py-10 max-md:p-8 flex flex-row items-justified-space-between max-md:flex-col">
        <div class="lg:w-2/5 max-lg:3/5 max-md:w-full flex flex-col gap-5 max-md:mb-6">
            <h1 class="text-[45px] font-bold mb-5"><?php echo e(get_the_title()); ?></h1>
            <p class="text-[20px]"><b>Cliente:</b> <?php echo e($client_name); ?></p>
            <p class="text-[20px]"><b>Abogado:</b> <?php echo e($lawyer_name); ?></p>
            <p class="text-[20px]"><b>Estado:</b> <?php echo e($estado); ?></p>
            <p class="text-[20px]"><b>Fecha de inicio:</b> <?php echo e($fecha_inicio); ?></p>
        </div>
        <div class="max-lg:hidden lg:w-1/5 flex items-center justify-center">
            <img src="<?php echo e($image_url); ?>" alt="Imagen tipo de caso">
        </div>
        <div class="max-md:w-full h-responsive w-2/5 bg-cover flex items-center justify-center max-md:mb-10">
            <!-- my calendar -->
            <div class="auto-jsCalendar" data-month-format="month YYYY"  data-day-format="DDD" data-language="es" data-first-day-of-the-week="2">
            </div>
        </div>
    </section>

    
    <section class="px-10 py-10">
        <h1 class="text-[40px] font-bold mb-8">Descripcion:</h1>
        <p class="text-[20px]"><?php echo nl2br(e($desc)); ?></p>
    </section>

    
    <section class="px-10 py-10">
        <div class="flex flex-row max-sm:flex-col items-center items-justified-space-between">
            <h1 class="text-[40px] font-bold mb-8">Eventos:</h1>
            <a href="#">Ver más</a>
        </div>
        <div class="flex md:flex-row items-justified-space-between">
            <div class="max-md:w-full h-responsive w-2/5 bg-cover flex items-center justify-center max-md:mb-10">
                <!-- my calendar -->
                <div class="auto-jsCalendar" data-month-format="month YYYY"  data-day-format="DDD" data-language="es" data-first-day-of-the-week="2">
                </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-10">
                <?php
                    $cuenta = 0;
                ?>
                <?php $__currentLoopData = $eventos->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $fecha_start = get_field('fecha-inicio', $evento->ID);
                        $fecha_end = get_field('fecha-fin', $evento->ID);

                        $caso_relacionado = get_field('caso-relacionado', $evento->ID);
                        $caso_relacionado = $caso_relacionado[0];

                        $tipo_caso_id = get_field('type', $caso_relacionado->ID);
                        $image_url = $tipo_caso_id ? get_field('category-pic', 'term_' . $tipo_caso_id) : null;

                        $client_id_ev = get_field('client', $caso_relacionado->ID);
                        $client_user_ev = get_userdata($client_id_ev);
                        $client_name_ev = $client_user_ev ? $client_user_ev->display_name : 'Cliente desconocido';

                        $lawyer_id_ev = get_field('lawyer', $caso_relacionado->ID);
                        $lawyer_user_ev = get_userdata($lawyer_id_ev);
                        $lawyer_name_ev = $lawyer_user_ev ? $lawyer_user_ev->display_name : 'Abogado desconocido';
                    ?>
                    <?php if($cuenta < 2): ?>
                        <?php if($caso_relacionado->ID == get_the_ID()): ?>
                            <?php
                                $cuenta++;
                            ?>
                            <div class="h-responsive bg-gray-200 border-0 rounded-[15px] flex flex-col justify-center gap-2 mb-6">
                                <div class="m-4 flex justify-center">
                                    <img src="<?php echo e($image_url); ?>" alt="Imagen tipo caso" class="h-[150px] border-0 rounded-[10px] object-cover">
                                </div>
                                <div class="mr-4 ml-4">
                                    <h3 class="text-[18px] font-bold mb-1"><?php echo e($evento->post_title); ?></h3>
                                    <p><strong>Cliente:</strong> <?php echo e($client_name_ev); ?></p>
                                    <p><strong>Abogado:</strong> <?php echo e($lawyer_name_ev); ?></p>
                                    <p><strong>Comienza:</strong> <?php echo e($fecha_start); ?></p>
                                    <p><strong>Finaliza:</strong> <?php echo e($fecha_end); ?></p>
                                </div>
                                <div class="m-4">
                                    <a href="<?php echo e(get_permalink($evento->ID)); ?>" class="inline-block hover:bg-[#767CB5] bg-[#6A6B75] text-white px-4 py-2 rounded transition">
                                        Ver evento
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?> 
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($cuenta == 0): ?> 
                    <div class="h-responsive border-0 rounded-[15px] flex flex-col justify-center gap-2 mb-6">
                        No hay eventos relacionados a este caso
                    </div>  
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php else: ?>
    <section class="flex items-center justify-center text-[60px] font-bold">
        No estás autorizado para ver este contenido
    </section>
<?php endif; ?>



<?php echo $__env->make('partials.organisms.organism-footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\adolfo.saenz\Local Sites\bufete-abogados\app\public\wp-content\themes\bufete-theme\resources\views/single-caso.blade.php ENDPATH**/ ?>