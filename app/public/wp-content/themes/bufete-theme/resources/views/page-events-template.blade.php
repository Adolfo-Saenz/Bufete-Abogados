{{--
  Template Name: Events Template
--}}

@extends('layouts.app')

{{-- Header --}}
@include('partials.organisms.organism-header')

{{-- Cases --}}
@if(isset($_GET['caso_id']))
  @include('partials.organisms.organism-lists', [
      'tipo' => 'events',
      'caso' => $_GET['caso_id'],
  ])
@else
  @include('partials.organisms.organism-lists', [
      'tipo' => 'events',
      'caso' => '',
  ])
@endif

{{-- Footer/Pie de página --}}
@include('partials.organisms.organism-footer')