@extends('layouts.app')

@php
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
  $post_id = get_the_ID();

  $comments_raw = get_comments([
    'post_id' => $post_id,
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
@endphp

<script>
  // Creo el script para las paginaciones
  window.testimonials = @json($comments);

  let comments = window.testimonials || [];
  let index = 0;

  function renderComment(i) {
    if (!comments[i]) return;
    document.getElementById('commentContent').textContent = comments[i].comment_content;
    document.getElementById('commentAuthor').textContent = comments[i].comment_author;
    document.getElementById('authorCity').textContent = comments[i].acf.city || '';
    document.getElementById('authorCountry').textContent = comments[i].acf.country || '';
    document.getElementById('authorImage').src = comments[i].acf.profile_image || 'https://via.placeholder.com/60';
  }

  function previousPage() {
    index = (index - 1 + comments.length) % comments.length;
    renderComment(index);
  }

  function nextPage() {
    index = (index + 1) % comments.length;
    renderComment(index);
  }

  // Mostrar el primer comentario al cargar
  document.addEventListener("DOMContentLoaded", () => renderComment(index));
</script>

{{-- Header --}}
<section class="h-[80px] bg-[#232536] px-5">
  <div class="flex items-center justify-between h-[80px]">
    <div class="flex items-center space-x-4">
      <img src="{{ Vite::asset('resources/images/logo.jpg') }}" alt="Tu imagen de perfil" class="w-[50px] h-[50px] rounded-full">
      <span class="text-[12px] text-white">Abogados</span>
    </div>
    <div class="flex items-center space-x-15">
      <nav class="max-md:hidden flex space-x-15 text-white font-medium">
        <a href="#">Inicio</a>
        <a href="#">Sobre nosotros</a>
        <a href="#">Abogados</a>
        <a href="#">Contáctanos</a>
      </nav>
      <a href="#" class="h-[50px] w-[150px] max-md:w-[130px] bg-white text-[#1e1f36] font-bold rounded-md hover:scale-105 transition-transform duration-200 flex items-center justify-center">
        Área de clientes
      </a>
    </div>
  </div>
</section>

{{-- Heading --}}
<section class="relative lg:h-[600px] h-responsive text-[#232536] flex max-md:grid max-md:grid-rows-2">
  <div class="bg-[#767CB5] lg:h-[600px] w-3/5 max-md:w-full h-responsive">
    <h1 class="text-[70px] max-sm:text-[55px] leading-22 font-bold lg:pl-12 pl-4 lg:mt-15 mt-10 lg:[width:700px] h-responsive">Contáctanos y cuéntanos como podemos ayudarte</h1>
    <p class="text-[25px] max-sm:text-[20px] leading-6 lg:pl-12 pl-4 pr-4 pt-15 lg:[width:600px] w-full h-responsive">Un bufete de abogados con más de 25 años de experiencia</p>
    <a href="#" class="boton text-[20px] lg:ml-12 ml-4 mt-15 lg:mb-0 mb-7 [width:186px] [height:65px] flex items-center justify-center bg-white text-[#232536] rounded-[10px] font-bold font-sans hover:scale-105 transition-transform duration-200">
      Área de clientes
    </a>
  </div>
  <div class="lg:h-[600px] h-responsive lg:w-full w-2/5 max-md:w-full bg-cover" style="background-image: url('{{ Vite::asset('resources/images/Heading.png') }}');"></div>
</section>

{{-- Especializaciones --}}
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
    @foreach ($categorias as $categoria)
      @php
        $image_url = get_field('category-pic', 'term_' . $categoria->term_id);
      @endphp
      <div class="h-responsive bg-gray-200 border-0 rounded-[15px] flex flex-col justify-center gap-2">
        <div class="m-4 flex justify-center">
          <img src="{{ $image_url }}" alt="{{ $categoria->name }}" class="h-[150px] border-0 rounded-[10px]">
        </div>
        <div class="mr-4 ml-4">
          <a href="#" class="text-[18px] font-bold">
            {{ $categoria->name }}
          </a>
        </div>
        <div class="m-4">
          {{ $categoria->description }}
        </div>
      </div>
    @endforeach
  </div>
</section>

{{-- Comentarios --}}
<section class="px-6 py-10 bg-[rgb(35,37,54)] text-white grid md:grid-cols-5">
  <div class="col-span-2 flex flex-col justify-center md:m-14 m-7">
    <p class="text-[16px] font-semibold">Comentarios</p>
    <h4 class="text-[36px] font-bold mt-2">¿Que opinan nuestros clientes sobre nosotros?</h4>
    <p class="text-[18px] mr-20 mt-3">Aquí podréis ver lo que nuestro clientes han opinado de nuestros servicios</p>
  </div>
  <div class="col-span-3">
    <div class="md:border-l max-md:border-t border-gray-300 mb-8 md:pl-30 pl-10 md:pr-30 pr-15 mt-14 flex flex-col justify-center">
      <p id="commentContent" class="text-[24px] font-bold pt-5 mr-10"></p>
      <div class="grid grid-cols-5 gap-2 mt-10 mb-5">
        <div class="col-span-1">
          <img id="authorImage" src="" alt="" class="h-15 w-15 border-0 rounded-full">
        </div>
        <div class="col-span-2 flex flex-col justify-center">
          <p id="commentAuthor" class="font-bold text-[24px]"></p>
          <p id="authorCity" class="text-[16px]"></p>
          <p id="authorCountry" class="text-[16px]"></p>
        </div>
        <div class="col-span-1 flex items-center justify-center">
          <button onclick="previousPage()" id="prevBtn" class="botonbl h-[48px] w-[48px] text-[20px] flex items-center justify-center border-0 rounded-full transition-transform duration-200 hover:scale-150 hover:bg-[#767CB5] bg-[#6A6B75]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
          </button>
        </div>
        <div class="col-span-1 flex items-center justify-center">
          <button onclick="nextPage()" id="nxtBtn" class="botonbl h-[48px] w-[48px] text-[20px] flex items-center justify-center border-0 rounded-full transition-transform duration-200 hover:scale-150 hover:bg-[#767CB5] bg-[#6A6B75]">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>  
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Footer/Pie de página --}}
<section class="py-10 bg-[#232536]">
  <div class="h-[80px] bg-[#232536] px-5">
    <div class="flex items-center justify-between h-[80px]">
      <div class="flex items-center space-x-4">
        <img src="{{ Vite::asset('resources/images/logo.jpg') }}" alt="Tu imagen de perfil" class="w-[50px] h-[50px] rounded-full">
        <span class="text-[12px] text-white">Abogados</span>
      </div>
      <div class="flex items-center space-x-15">
        <nav class="max-md:hidden flex space-x-15 text-white font-medium">
          <a href="#">Inicio</a>
          <a href="#">Sobre nosotros</a>
          <a href="#">Abogados</a>
          <a href="#">Contáctanos</a>
        </nav>
        <a href="#" class="h-[50px] w-[150px] max-md:w-[130px] bg-white text-[#1e1f36] font-bold rounded-md hover:scale-105 transition-transform duration-200 flex items-center justify-center">
          Área de clientes
        </a>
      </div>
    </div>
  </div>


  @if (is_user_logged_in())
    <div class="mx-6 my-10 bg-[#2A2B39] grid grid-cols-9 items-center p-6 rounded-lg">
      <p class="md:ml-10 col-span-4 text-[28px] md:text-[34px] font-bold text-white">
        Escribe tu comentario
      </p>
      <form action="{{ site_url('/wp-comments-post.php') }}" method="post" class="col-span-5 flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0 ml-10 max-sm:w-[150px] sm:w-[300px] md:w-[372px] lg:w-[500px]">
        {{-- Obligatorio para que el comentario se asocie al post correcto --}}
        <input type="hidden" name="comment_post_ID" value="{{ $post_id }}">
        <input type="hidden" name="comment_parent" value="0">

        {{-- Mantenerse en la misma página después de comentar --}}
        <input type="hidden" name="redirect_to" value="{{ get_permalink() }}">

        {{-- Campo de comentario --}}
        <input 
          type="text" 
          name="comment" 
          required 
          class="h-[60px] md:w-[400px] px-4 border-0 rounded-[10px] bg-white text-gray-800 text-[16px]" 
          placeholder="Escribe tu comentario aquí...">

        {{-- Botón de enviar --}}
        <button type="submit" class="boton text-[16px] md:text-[20px] w-full md:w-[180px] h-[60px] flex items-center justify-center text-white rounded-[10px] font-bold font-sans bg-[#6A6B75] hover:bg-[#767CB5] hover:scale-105 transition-transform duration-200">
          Enviar
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 ml-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
          </svg>
        </button>
      </form>
    </div>
  @else
    <div class="mx-2 my-10 bg-[#2A2B39] p-6 rounded-lg text-white text-center">
      <p class="text-[20px]">Debes iniciar sesión para dejar un comentario.</p>
      <a href="{{ wp_login_url(get_permalink()) }}" class="inline-block mt-4 px-6 py-3 bg-blue-600 rounded-[10px] font-bold hover:bg-blue-700 transition">
        Iniciar sesión
      </a>
    </div>
  @endif

  {{-- Script para evitar redireccionamiento a página de comentarios --}}
  <script>
    document.querySelector('form').addEventListener('submit', function(e){
      // Permitir que el formulario se envíe normalmente, pero evitar el redireccionamiento al recargar la página
      e.preventDefault();

      // Enviar el formulario manualmente
      fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        credentials: 'same-origin'
      }).then(() => {
        // Recargar la misma página para que se refresquen los comentarios
        window.location.href = window.location.href.split('#')[0];
      });
    });
  </script>

  <div class="mx-6 flex items-center justify-between">
    <div class="text-[16px] text-gray-400 font-semibold ml-2">
      <p>Finstreet 118 2561 abctown</p>
      <p>example@femail.com  001 21345 442</p>
    </div>
    <div>
      <img src="{{-- {{ Vite::asset('resources/images/Social_wrapper.png') }} --}}" alt="{{-- Redes sociales --}}">
    </div>
  </div>
</section>