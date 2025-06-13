{{-- Cases single template --}}
@extends('layouts.app')

@php
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

<section class="px-10 py-10 flex flex-row">
    <div class="lg:w-2/5 max-lg:3/5 flex flex-col gap-5">
        <h1 class="text-[45px] font-bold mb-5">{{ get_the_title() }}</h1>
        <p class="text-[20px]"><b>Cliente:</b> {{ $client_name }}</p>
        <p class="text-[20px]"><b>Abogado:</b> {{ $lawyer_name }}</p>
        <p class="text-[20px]"><b>Estado:</b> {{ $estado }}</p>
        <p class="text-[20px]"><b>Fecha de inicio:</b> {{ $fecha_inicio }}</p>
    </div>
    <div class="max-lg:hidden lg:w-1/5 flex items-center justify-center">
        <img src="{{ $image_url }}" alt="Imagen tipo de caso">
    </div>
    <div class="h-responsive w-2/5 bg-cover flex items-center justify-center max-md:mb-10">
        <!-- my calendar -->
        <div class="auto-jsCalendar" data-month-format="month YYYY"  data-day-format="DDD" data-language="es" data-first-day-of-the-week="2">
        </div>
    </div>
</section>

@include('partials.organisms.organism-footer')