<?php
  /* Obtener los últimos 4 posts */
  $latests_posts = get_posts([
    'posts_per_page' => 4,
  ]);

  /* Obtenemos las categorías de Wordpress */
  $categorias = get_categories([
    'hide_empty' => false, // mostrar también las vacías
    'number' => 4,
  ]);

  /* Obtener los comentarios */
  $comments_raw = get_comments([
    'status'  => 'approve',
    'orderby' => 'comment_date',
    'order'   => 'DESC',
  ]);

  /* Obtener los datos del autor del post, el contenido y la fecha */
  $comments = array_map(function ($comment) {
    $user_id = $comment->user_id;

    return [
      'comment_content' => $comment->comment_content,
      'comment_author' => $comment->comment_author,
      'comment_date' => $comment->comment_date,
      'acf' => [
        'city' => get_field('city', 'user_' . $user_id),
        'country' => get_field('country', 'user_' . $user_id),
        'profile_image' => get_field('profile-image', 'user_' . $user_id),
      ],
    ];
  }, $comments_raw);
?>

<script>
    // Creo el script para las paginaciones
    window.testimonials = <?php echo json_encode($comments, 15, 512) ?>;
</script>


<section class="h-[80px] bg-[#232536] px-5">
  <div class="flex items-center justify-between h-[80px]">
    <div class="flex items-center space-x-4">
      <img src="<?php echo e(Vite::asset('resources/images/logo.jpg')); ?>" alt="Tu imagen de perfil" class="w-[50px] h-[50px] rounded-full">
      <span class="text-[12px] text-white">Abogados</span>
    </div>
    <div class="flex items-center space-x-15">
      <nav class="max-md:hidden flex space-x-15 text-white font-medium">
        <a href="#">Inicio</a>
        <a href="#">Sobre nosotros</a>
        <a href="#">Abogados</a>
        <a href="#">Contáctanos</a>
      </nav>
      <a href="#" class="h-[50px] w-[150px] bg-white text-[#1e1f36] font-bold rounded-md hover:scale-105 transition-transform duration-200 flex items-center justify-center">
        Área de clientes
      </a>
    </div>
  </div>
</section>


<section class="relative lg:h-[600px] h-responsive text-[#232536] flex max-md:grid max-md:grid-rows-3">
  <div class="bg-[#767CB5] lg:h-[600px] w-3/5 max-md:w-full h-responsive">
    <h1 class="text-[70px] max-sm:text-[55px] leading-22 font-bold lg:pl-12 pl-4 lg:mt-15 mt-10 lg:[width:700px] h-responsive">Contáctanos y cuéntanos como podemos ayudarte</h1>
    <p class="text-[25px] max-sm:text-[20px] leading-6 lg:pl-12 pl-4 pr-4 pt-15 lg:[width:600px] w-full h-responsive">Un bufete de abogados con más de 25 años de experiencia</p>
    <a href="#" class="boton text-[20px] lg:ml-12 ml-4 mt-15 lg:mb-0 mb-7 [width:186px] [height:65px] flex items-center justify-center bg-white text-[#232536] rounded-[10px] font-bold font-sans hover:scale-105 transition-transform duration-200">
      Área de clientes
    </a>
  </div>
  <div class="lg:h-[600px] h-responsive lg:w-full w-2/5 max-md:w-full bg-cover" style="background-image: url('<?php echo e(Vite::asset('resources/images/Heading.png')); ?>');"></div>
</section>


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


<section class="px-6 py-10 bg-[#232536]">
  <div class="h-[80px] bg-[#232536] px-5">
    <div class="flex items-center justify-between h-[80px]">
      <div class="flex items-center space-x-4">
        <img src="<?php echo e(Vite::asset('resources/images/logo.jpg')); ?>" alt="Tu imagen de perfil" class="w-[50px] h-[50px] rounded-full">
        <span class="text-[12px] text-white">Abogados</span>
      </div>
      <div class="flex items-center space-x-15">
        <nav class="max-md:hidden flex space-x-15 text-white font-medium">
          <a href="#">Inicio</a>
          <a href="#">Sobre nosotros</a>
          <a href="#">Abogados</a>
          <a href="#">Contáctanos</a>
        </nav>
        <a href="#" class="h-[50px] w-[150px] bg-white text-[#1e1f36] font-bold rounded-md hover:scale-105 transition-transform duration-200 flex items-center justify-center">
          Área de clientes
        </a>
      </div>
    </div>
  </div>





  <div class="mx-2 my-10 h-[235px] bg-[#2A2B39] grid grid-cols-9 items-center">
    <p class="ml-10 col-span-4 text-[34px] font-bold text-white">Subscribe to our news letter to get latest updates and news</p>
    <form action="" class="col-span-5 flex items-center space-x-4 ml-25">
      <input type="email" name="mail" class="h-[60px] md:w-[280px] border-0 rounded-[10px] bg-white text-gray-500 text-[20px] placeholder:ml-4" placeholder="example@gmail.com">
      <button type="button" class="boton text-[20px] w-[180px] h-[60px] flex items-center justify-center text-white rounded-[10px] font-bold font-sans">
        
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 rotate-325">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
        </svg>                                  
      </button>
    </form>
  </div>
  <div class="flex items-center justify-between">
    <div class="text-[16px] text-gray-400 font-semibold ml-2">
      <p>Finstreet 118 2561 abctown</p>
      <p>example@femail.com  001 21345 442</p>
    </div>
    <div>
      <img src="<?php echo e(Vite::asset('resources/images/Social_wrapper.png')); ?>" alt="Redes sociales">
    </div>
  </div>
</section>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\adolfo.saenz\Local Sites\bufete-abogados\app\public\wp-content\themes\bufete-theme\resources\views/index.blade.php ENDPATH**/ ?>