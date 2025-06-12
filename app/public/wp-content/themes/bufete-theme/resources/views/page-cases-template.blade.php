{{--
  Template Name: Cases Template
--}}

@extends('layouts.app')

{{-- Header --}}
@include('partials.organisms.organism-header')

{{-- Cases --}}
<div class="flex items-center space-x-2 mb-5">
    <h3 class="font-bold text-[55px]">Facturas</h3>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
        </svg>  
</div>

{{-- Footer/Pie de página --}}
@include('partials.organisms.organism-footer')