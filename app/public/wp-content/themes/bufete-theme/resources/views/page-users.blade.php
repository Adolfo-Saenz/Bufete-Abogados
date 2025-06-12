{{--
  Template Name: Users Template
--}}

@extends('layouts.app')

@php
    $user = wp_get_current_user();
    $user_id = $user->ID;
    $user_name = $user->user_nicename;
    $role = $user->roles;

    $city = get_field('city', 'user_' . $user_id);
    $country = get_field('country', 'user_' . $user_id);
    $profile_image = get_field('profile-image', 'user_' . $user_id);
@endphp
<head>
    <!-- jsCalendar v1.4.5 Javascript and CSS from unpkg cdn -->
    <script src="https://unpkg.com/simple-jscalendar@1.4.5/source/jsCalendar.min.js" integrity="sha384-F3Wc9EgweCL3C58eDn9902kdEH6bTDL9iW2JgwQxJYUIeudwhm4Wu9JhTkKJUtIJ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/simple-jscalendar@1.4.5/source/jsCalendar.min.css" integrity="sha384-CTBW6RKuDwU/TWFl2qLavDqLuZtBzcGxBXY8WvQ0lShXglO/DsUvGkXza+6QTxs0" crossorigin="anonymous">
    <!-- Load spanish language -->
    <script type="text/javascript" src="jsCalendar.lang.es.js"></script>
</head>

{{-- Header --}}
@include('partials.organisms.organism-header')

{{-- Heading Users / Lawyers / Admins --}}
<section class="relative lg:h-[500px] h-responsive text-[#232536] bg-[#6A6B75] flex max-md:flex max-md:flex-col max-md:justify-center max-md:gap-2 w-full">
    <div class="lg:h-[500px] w-full md:w-3/5 h-responsive max-lg:mt-10">
        <div class="flex lg:flex-row flex-col items-center lg:ml-10 lg:my-25">
            @if($profile_image != "")
                <img src="{{ $profile_image }}" alt="Tu imagen de perfil" class="w-[300px] h-[300px] rounded-full">
            @else
                <img src="http://bufete-abogados.local/wp-content/uploads/2025/06/default.png" alt="Tu imagen de perfil" class="w-[300px] h-[300px] rounded-full">
            @endif
            <div class="max-lg:flex max-lg:flex-col max-lg:items-center max-lg:text-center">
                <p class="max-sm:text-[40px] text-[50px] leading-22 font-bold h-responsive lg:pl-12 max-lg:px-4">
                    {{ Str::limit($user_name, limit: 12) }}
                </p>
                <p class="text-[25px] max-sm:text-[20px] leading-6 lg:pl-12 px-4 lg:[width:600px] w-full h-responsive">
                    @if ($city != "")
                        @if($country != "")
                            {{ $city }}, {{ $country }}
                        @else
                            {{ $city }}, Pais no registrado
                        @endif
                    @else
                        @if($country != "")
                            Ciudad no registrada, {{ $country }}
                        @elseif($country == "" && $city == "")
                            No hay datos de localidades
                        @endif
                    @endif
                </p>
                <a href="{{ "http://bufete-abogados.local/wp-admin/profile.php" }}" class="boton text-[20px] lg:ml-12 mt-10 lg:mb-0 mb-7 [width:186px] [height:65px] flex items-center justify-center bg-white text-[#232536] rounded-[10px] font-bold font-sans hover:scale-105 transition-transform duration-200">
                    Editar perfil
                </a>
            </div>
        </div>
    </div>
    <div class="lg:h-[500px] h-responsive md:w-2/5 bg-cover flex items-center justify-center max-md:mb-10">
        <!-- my calendar -->
        <div class="auto-jsCalendar" data-month-format="month YYYY"  data-day-format="DDD" data-language="es" data-first-day-of-the-week="2">
        </div>
    </div>
</section>

{{-- Casos --}}
@include('partials.organisms.organism-cards', [
    'tipo' => 'Case'
])

{{-- Eventos --}}
@include('partials.organisms.organism-cards', [
    'tipo' => 'Event'
])

{{-- Facturas --}}
@include('partials.organisms.organism-cards', [
    'tipo' => 'Bills'
])

{{-- Footer/Pie de página --}}
@include('partials.organisms.organism-footer')