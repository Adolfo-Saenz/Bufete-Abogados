{{-- Lists of cases, events or bills --}}

@php
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $perfil = $user->roles;

    $args = [
        'post_type' => 'caso',
    ];
    $query = new WP_Query($args);

    $argsEventos = [
        'post_type' => 'evento',
    ];
    $eventos = new WP_Query($argsEventos);
@endphp

@if($tipo == 'cases')
    <section>
        <div class="flex items-center space-x-2 mt-5 mb-5">
            <h3 class="font-bold text-[45px] ml-8">Casos</h3>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
            </svg>  
        </div>
        @php
            $cuenta = 0;
        @endphp
        @foreach ($query->posts as $caso)
            @php
                $tipo_caso_id = get_field('type', $caso->ID);
                $image_url = $tipo_caso_id ? get_field('category-pic', 'term_' . $tipo_caso_id) : null;

                $client_id = get_field('client', $caso->ID);
                $client_user = get_userdata($client_id);
                $client_name = $client_user ? $client_user->display_name : 'Cliente desconocido';
                $client_image = get_field('profile-image', 'user_' . $client_id);

                $lawyer_id = get_field('lawyer', $caso->ID);
                $lawyer_user = get_userdata($lawyer_id);
                $lawyer_name = $lawyer_user ? $lawyer_user->display_name : 'Abogado desconocido';
                $lawyer_image = get_field('profile-image', 'user_' . $lawyer_id);

                $desc = get_field('desc', $caso->ID);
            @endphp
            @if($client_id == $user_id || $lawyer_id == $user_id ||(current_user_can('administrator')))
                @php
                    $cuenta++;
                @endphp
                <div class="border border-gray-400 py-5 px-10">
                    <div class="mb-7 grid grid-cols-5 max-lg:grid-cols-4 gap-4">
                        <div class="max-lg:col-span-4 col-span-1 flex items-center justify-center">
                            <img src="{{ $image_url }}" alt="Imagen tipo caso" class="h-[150px] border-0 rounded-[10px] object-cover">
                        </div>
                        <div class="col-span-4">
                            {{-- Título del caso --}}
                            <h1 class="mb-2 text-[30px] font-bold">{{ $caso->post_title }}</h1>
                            {{-- Abogado y cliente --}}
                            <div class="flex flex-row items-center gap-4 mb-3">
                                @if($lawyer_image != "")
                                    <img src="{{ $lawyer_image }}" alt="Imagen Juez" class="w-[40px] h-[40px] rounded-full">
                                @else
                                    <img src="http://bufete-abogados.local/wp-content/uploads/2025/06/default.png" alt="Imagen Juez" class="w-[40px] h-[40px] rounded-full">
                                @endif
                                <p>{{ $lawyer_name }}</p>
                            </div>
                            <div class="flex flex-row items-center gap-4 mb-3">
                                @if($client_image != "")
                                    <img src="{{ $client_image }}" alt="Imagen cliente" class="w-[40px] h-[40px] rounded-full">
                                @else
                                    <img src="http://bufete-abogados.local/wp-content/uploads/2025/06/default.png" alt="Imagen cliente" class="w-[40px] h-[40px] rounded-full">
                                @endif
                                <p>{{ $client_name }}</p>
                            </div>
                            {{-- Contenido del post --}}
                            <p class="text-[15px] mt-4 mb-4">
                                {{ wp_trim_words($desc, 30, '...') }}
                            </p>
                            {{-- Botón --}}
                            <div>
                                <a href="{{ get_permalink($caso->ID) }}" class="inline-block hover:bg-[#767CB5] bg-[#6A6B75] text-white px-4 py-2 rounded transition">
                                    Leer caso
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        @if ($cuenta == 0) 
            <div class="h-responsive border-0 rounded-[15px] flex flex-col justify-center gap-2 mb-6 ml-6">
                No perteneces a ningún caso
            </div>  
        @endif
    </section>
@elseif($tipo == 'events')
    <section>
        <div class="flex items-center space-x-2 mt-5 mb-5">
            <h3 class="font-bold text-[45px] ml-8">Eventos</h3>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
            </svg>  
        </div>
        @php
            $cuenta = 0;
        @endphp
        @foreach ($eventos->posts as $evento)
            @php
                $fecha_start = get_field('fecha-inicio', $evento->ID);
                $fecha_end = get_field('fecha-fin', $evento->ID);

                $caso_relacionado = get_field('caso-relacionado', $evento->ID);
                $caso_relacionado = $caso_relacionado[0];

                $tipo_caso_id = get_field('type', $caso_relacionado->ID);
                $image_url = $tipo_caso_id ? get_field('category-pic', 'term_' . $tipo_caso_id) : null;

                $client_id_ev = get_field('client', $caso_relacionado->ID);
                $client_user_ev = get_userdata($client_id_ev);
                $client_name_ev = $client_user_ev ? $client_user_ev->display_name : 'Cliente desconocido';
                $client_image_ev = get_field('profile-image', 'user_' . $client_id_ev);
        
                $lawyer_id_ev = get_field('lawyer', $caso_relacionado->ID);
                $lawyer_user_ev = get_userdata($lawyer_id_ev);
                $lawyer_name_ev = $lawyer_user_ev ? $lawyer_user_ev->display_name : 'Abogado desconocido';
                $lawyer_image_ev = get_field('profile-image', 'user_' . $lawyer_id_ev);
            @endphp


            @if($client_id_ev == $user_id || $lawyer_id_ev == $user_id ||(current_user_can('administrator')))
                @php
                    $cuenta++;
                @endphp
                <div class="border border-gray-400 py-5 px-10">
                    <div class="mb-7 grid grid-cols-5 max-lg:grid-cols-4 gap-4">
                        <div class="max-lg:col-span-4 col-span-1 flex items-center justify-center">
                            <img src="{{ $image_url }}" alt="Imagen tipo caso" class="h-[150px] border-0 rounded-[10px] object-cover">
                        </div>
                        <div class="col-span-4">
                            {{-- Título del caso --}}
                            <h1 class="mb-2 text-[30px] font-bold">{{ $evento->post_title }}</h1>
                            {{-- Abogado y cliente --}}
                            <div class="flex flex-row items-center gap-4 mb-3">
                                <p><b>Caso: </b> {{ get_the_title($caso_relacionado) }}</p>
                            </div>
                            <div class="flex flex-row items-center gap-4 mb-3">
                                <p><b>Fecha inicio: </b>{{ $fecha_start }}</p>
                            </div>
                            <div class="flex flex-row items-center gap-4 mb-3">
                                <p><b>Fecha fin: </b>{{ $fecha_end }}</p>
                            </div>
                            {{-- Botón --}}
                            <div>
                                <a href="{{ get_permalink($evento->ID) }}" class="inline-block hover:bg-[#767CB5] bg-[#6A6B75] text-white px-4 py-2 rounded transition">
                                    Ver evento
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        @if ($cuenta == 0) 
            <div class="h-responsive border-0 rounded-[15px] flex flex-col justify-center gap-2 mb-6 ml-6">
                No tienes ningún evento programado
            </div>  
        @endif
    </section>
@endif