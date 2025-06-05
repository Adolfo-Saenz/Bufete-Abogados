{{-- Footer/Pie de página --}}
<section class="py-10 bg-[#232536]">
    @include('partials.organisms.organism-header')


    @if (is_user_logged_in())
        <div class="mx-6 my-10 bg-[#2A2B39] grid grid-cols-9 items-center p-6 rounded-lg">
            <p class="md:ml-10 col-span-4 text-[28px] md:text-[34px] font-bold text-white">
                Escribe tu comentario.
            </p>
            <form action="{{ site_url('/wp-comments-post.php') }}" method="post" class="col-span-5 flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0 ml-10 max-sm:w-[150px] sm:w-[300px] md:w-[372px] lg:w-[500px]">
                {{-- Obligatorio para que el comentario se asocie al post correcto --}}
                <input type="hidden" name="comment_post_ID" value="{{ $post_id }}">
                <input type="hidden" name="comment_parent" value="0">

                {{-- Mantenerse en la misma página después de comentar --}}
                <input type="hidden" name="redirect_to" value="{{ get_permalink() }}">

                {{-- Campo de comentario --}}
                <input type="text" name="comment" required class="h-[60px] md:w-[400px] px-4 border-0 rounded-[10px] bg-white text-gray-800 text-[16px]" placeholder="Escribe tu comentario aquí...">

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
        <a href="{{ "http://bufete-abogados.local/formulario-de-registro/" }}" class="inline-block mt-4 px-6 py-3 bg-[#6A6B75] rounded-[10px] font-bold hover:bg-[#767CB5] hover:scale-105 transition-transform duration-200">
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