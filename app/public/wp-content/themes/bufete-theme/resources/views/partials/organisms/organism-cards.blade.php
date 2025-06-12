{{-- Especializaciones / Casos / Facturas / Eventos --}}
@php
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $perfil = $user->roles;

    /* Obtenemos las categorías de Wordpress */
    $categorias = get_categories([
        'hide_empty' => false, // mostrar las vacías
        'number' => 4,
    ]);

    $args = [
        'post_type' => 'caso',
    ];
    $query = new WP_Query($args);

    $argsEventos = [
        'post_type' => 'evento',
    ];
    $eventos = new WP_Query($argsEventos);

    $argsBills = [
        'post_type' => 'factura',
    ];
    $bills = new WP_Query($argsBills);
@endphp

@if($tipo == "Espec")
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
@elseif($tipo == "Case")
    {{-- Casos --}}
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

                    $lawyer_id = get_field('lawyer', $caso->ID);
                    $lawyer_user = get_userdata($lawyer_id);
                    $lawyer_name = $lawyer_user ? $lawyer_user->display_name : 'Abogado desconocido';
                @endphp
                @if($cuenta < 4)
                    @if($client_id == $user_id || $lawyer_id == $user_id)
                        @php
                            $cuenta++;
                        @endphp
                        <div class="h-responsive bg-gray-200 border-0 rounded-[15px] flex flex-col justify-center gap-2 mb-6">
                            <div class="m-4 flex justify-center">
                                <img src="{{ $image_url }}" alt="Imagen tipo caso" class="h-[150px] border-0 rounded-[10px] object-cover">
                            </div>
                            <div class="mr-4 ml-4">
                                <h3 class="text-[18px] font-bold mb-1">{{ $caso->post_title }}</h3>
                                <p><strong>Cliente:</strong> {{ $client_name }}</p>
                                <p><strong>Abogado(s):</strong> {{ $lawyer_name }}</p>
                            </div>
                            <div class="m-4">
                                <a href="{{ $caso->guid }}" class="inline-block hover:bg-[#767CB5] bg-[#6A6B75] text-white px-4 py-2 rounded transition">
                                    Leer caso
                                </a>
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
            @if ($cuenta == 0) 
                <div class="h-responsive border-0 rounded-[15px] flex flex-col justify-center gap-2 mb-6">
                    No perteneces a ningún caso
                </div>  
            @endif
        </div>
    </section>
@elseif($tipo == "Event")
    {{-- Eventos --}}
    <section class="px-6 py-10">
        <div class="grid grid-cols-1 gap-2 lg:grid-cols-[1fr_auto] items-center mb-3">
            <div class="flex items-center space-x-2">
                <h3 class="font-bold text-[25px]">Eventos</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                </svg>  
            </div>
            <a href="#" class="text-[16px] w-[70px] h-[25px]">Ver todos</a>
        </div>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
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

                    $lawyer_id_ev = get_field('lawyer', $caso_relacionado->ID);
                    $lawyer_user_ev = get_userdata($lawyer_id_ev);
                    $lawyer_name_ev = $lawyer_user_ev ? $lawyer_user_ev->display_name : 'Abogado desconocido';
                @endphp
                @if($cuenta < 4)
                    @if($client_id_ev == $user_id || $lawyer_id_ev == $user_id)
                        @php
                            $cuenta++;
                        @endphp
                        <div class="h-responsive bg-gray-200 border-0 rounded-[15px] flex flex-col justify-center gap-2 mb-6">
                            <div class="m-4 flex justify-center">
                                <img src="{{ $image_url }}" alt="Imagen tipo caso" class="h-[150px] border-0 rounded-[10px] object-cover">
                            </div>
                            <div class="mr-4 ml-4">
                                <h3 class="text-[18px] font-bold mb-1">{{ $evento->post_title }}</h3>
                                <p><strong>Cliente:</strong> {{ $client_name_ev }}</p>
                                <p><strong>Abogado:</strong> {{ $lawyer_name_ev }}</p>
                                <p><strong>Comienza:</strong> {{ $fecha_start }}</p>
                                <p><strong>Finaliza:</strong> {{ $fecha_end }}</p>
                            </div>
                            <div class="m-4">
                                <a href="{{ $evento->guid }}" class="inline-block hover:bg-[#767CB5] bg-[#6A6B75] text-white px-4 py-2 rounded transition">
                                    Ver evento
                                </a>
                            </div>
                        </div>
                    @endif 
                @endif
            @endforeach
            @if ($cuenta == 0) 
                <div class="h-responsive border-0 rounded-[15px] flex flex-col justify-center gap-2 mb-6">
                    No tienes ningún evento
                </div>  
            @endif
        </div>
    </section>
@elseif($tipo == "Bills")
    {{-- Facturas --}}
    @if(current_user_can('cliente'))
        <section class="px-6 py-10">
            <div class="grid grid-cols-1 gap-2 lg:grid-cols-[1fr_auto] items-center mb-3">
                <div class="flex items-center space-x-2">
                    <h3 class="font-bold text-[25px]">Facturas</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                    </svg>  
                </div>
                <a href="#" class="text-[16px] w-[70px] h-[25px]">Ver todas</a>
            </div>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @php
                    $cuenta = 0;
                @endphp
                @foreach ($bills->posts as $bill)
                    @php
                        $evento_relacionado = get_field('evento', $bill->ID);
                        $evento_relacionado = $evento_relacionado[0];
                        $caso_relacionado = get_field('caso-relacionado', $evento_relacionado->ID);
                        $caso_relacionado = $caso_relacionado[0];

                        $tipo_caso_id = get_field('type', $caso_relacionado->ID);
                        $image_url = $tipo_caso_id ? get_field('category-pic', 'term_' . $tipo_caso_id) : null;

                        $client_id_ev = get_field('client', $caso_relacionado->ID);
                        $client_user_ev = get_userdata($client_id_ev);
                        $client_name_ev = $client_user_ev ? $client_user_ev->display_name : 'Cliente desconocido';

                        $lawyer_id_ev = get_field('lawyer', $caso_relacionado->ID);
                        $lawyer_user_ev = get_userdata($lawyer_id_ev);
                        $lawyer_name_ev = $lawyer_user_ev ? $lawyer_user_ev->display_name : 'Abogado desconocido';

                        $fecha_inicio_o = get_field('fecha-inicio', $evento_relacionado->ID);
                        $fecha_fin_o = get_field('fecha-fin', $evento_relacionado->ID);
                        $precio_hora = get_field('precio-hora', $bill->ID);

                        $formato = 'd/m/Y g:i a';
                        $fecha_inicio = DateTime::createFromFormat($formato, $fecha_inicio_o);
                        $fecha_fin = DateTime::createFromFormat($formato, $fecha_fin_o);
                        $intervalo = $fecha_inicio->diff($fecha_fin);
                        $horas = $intervalo->h + ($intervalo->days * 24); // incluye días convertidos a horas
                        $minutos = $intervalo->i;
                        $horas_totales_decimal = $horas + ($minutos / 60);
                        $total_pagar = $horas_totales_decimal * $precio_hora;
                    @endphp
                    @if($cuenta < 4)
                        @if($client_id_ev == $user_id)
                            @php
                                $cuenta++;
                            @endphp
                            <div class="h-responsive bg-gray-200 border-0 rounded-[15px] flex flex-col justify-center gap-2 mb-6">
                                <div class="m-4 flex justify-center">
                                    <img src="{{ $image_url }}" alt="Imagen tipo caso" class="h-[150px] border-0 rounded-[10px] object-cover">
                                </div>
                                <div class="mr-4 ml-4">
                                    <h3 class="text-[18px] font-bold mb-1">{{ $bill->post_title }}</h3>
                                    <p><strong>Evento:</strong> {{ $evento_relacionado->post_title }}</p>
                                    <p><strong>Abogado:</strong> {{ $lawyer_name_ev }}</p>
                                    @if($horas > 1)
                                        @if($minutos == "")
                                            <p><strong>Tiempo:</strong> {{ $horas }} Horas</p>
                                        @else
                                            <p><strong>Tiempo:</strong> {{ $horas }} Horas y {{ $minutos }} minutos</p>
                                        @endif
                                    @else
                                        @if($minutos == "")
                                            <p><strong>Tiempo:</strong> {{ $horas }} Hora</p>
                                        @else
                                            <p><strong>Tiempo:</strong> {{ $horas }} Hora y {{ $minutos }} minutos</p>
                                        @endif
                                    @endif
                                    <p><strong>Total a pagar:</strong> {{ $total_pagar }} €</p>
                                </div>
                                <div class="m-4">
                                    <a href="{{ $bill->guid }}" class="inline-block hover:bg-[#767CB5] bg-[#6A6B75] text-white px-4 py-2 rounded transition">
                                        Ver factura
                                    </a>
                                </div>
                            </div>
                        @endif 
                    @endif
                @endforeach
                @if ($cuenta == 0) 
                    <div class="h-responsive border-0 rounded-[15px] flex flex-col justify-center gap-2 mb-6">
                        No tienes ninguna factura
                    </div>  
                @endif
            </div>
        </section>
    @endif
@endif