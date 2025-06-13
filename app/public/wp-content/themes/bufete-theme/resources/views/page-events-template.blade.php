{{--
  Template Name: Events Template
--}}

@extends('layouts.app')

{{-- Header --}}
@include('partials.organisms.organism-header')

{{-- Cases --}}
@include('partials.organisms.organism-lists', [
    'tipo' => 'events',
])

{{-- Footer/Pie de página --}}
@include('partials.organisms.organism-footer')