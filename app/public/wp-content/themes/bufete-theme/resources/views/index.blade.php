@extends('layouts.app')

@php
  /* Obtener los últimos 4 posts */
  $latests_posts = get_posts([
    'posts_per_page' => 4,
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
@include('partials.organisms.organism-header')

{{-- Heading --}}
<section class="relative lg:h-[600px] h-responsive text-[#232536] flex max-md:grid max-md:grid-rows-2">
  <div class="bg-[#767CB5] lg:h-[600px] w-3/5 max-md:w-full h-responsive">
    <h1 class="text-[70px] max-sm:text-[55px] leading-22 font-bold lg:pl-12 pl-4 lg:mt-15 mt-10 lg:[width:700px] h-responsive">Contáctanos y cuéntanos como podemos ayudarte</h1>
    <p class="text-[25px] max-sm:text-[20px] leading-6 lg:pl-12 pl-4 pr-4 pt-15 lg:[width:600px] w-full h-responsive">Un bufete de abogados con más de 25 años de experiencia</p>
    <a href="{{ is_user_logged_in() ? 'http://bufete-abogados.local/users-page/' : "http://bufete-abogados.local/formulario-de-registro/" }}" class="boton text-[20px] lg:ml-12 ml-4 mt-15 lg:mb-0 mb-7 [width:186px] [height:65px] flex items-center justify-center bg-white text-[#232536] rounded-[10px] font-bold font-sans hover:scale-105 transition-transform duration-200">
      Área de clientes
    </a>
  </div>
  <div class="lg:h-[600px] h-responsive lg:w-full w-2/5 max-md:w-full bg-cover" style="background-image: url('{{ Vite::asset('resources/images/Heading.png') }}');"></div>
</section>

{{-- Especializaciones --}}
@include('partials.organisms.organism-cards', [
  'tipo' => 'Espec',
]);

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
@include('partials.organisms.organism-footer')