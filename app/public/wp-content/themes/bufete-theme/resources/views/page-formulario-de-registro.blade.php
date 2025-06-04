{{--
  Template Name: Register Template
--}}

@extends('layouts.app')

<div class="max-w-4xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-2 gap-10">

  {{-- LOGIN --}}
  <div>
    <h2 class="text-xl font-bold mb-4">Iniciar sesión</h2>
    @if(!is_user_logged_in())
      @if(isset($_GET['login']) && $_GET['login'] === 'failed')
        <p class="text-red-500">Error al iniciar sesión.</p>
      @endif
      <form method="post" action="{{ wp_login_url(home_url()) }}" class="space-y-4">
        <input type="text" name="log" placeholder="Correo" required class="w-full border rounded px-3 py-2">
        <input type="password" name="pwd" placeholder="Contraseña" required class="w-full border rounded px-3 py-2">
        <input type="submit" value="Iniciar sesión" class="bg-[#6A6B75] text-white px-4 py-2 rounded hover:bg-[#767CB5]">
      </form>
    @else
      <p>Ya estás logueado.</p>
    @endif
  </div>

  {{-- REGISTRO --}}
  <div>
    <h2 class="text-xl font-bold mb-4">Registro</h2>
    @if(!is_user_logged_in())
      <form method="post" enctype="multipart/form-data" class="space-y-4">
        <input type="text" name="first_name" placeholder="Nombre" required class="w-full border rounded px-3 py-2">
        <input type="text" name="last_name" placeholder="Apellidos" required class="w-full border rounded px-3 py-2">
        <input type="email" name="email" placeholder="Correo electrónico" required class="w-full border rounded px-3 py-2">
        <input type="password" name="password" placeholder="Contraseña" required class="w-full border rounded px-3 py-2">
        <input type="text" name="tlf" placeholder="Número de teléfono" class="w-full border rounded px-3 py-2">
        <input type="text" name="country" placeholder="País" class="w-full border rounded px-3 py-2">
        <input type="text" name="city" placeholder="Ciudad" class="w-full border rounded px-3 py-2">
        <input type="file" name="profile_image" accept="image/*" class="w-full border rounded px-3 py-2">
        <button type="submit" name="custom_register" class="bg-[#6A6B75] text-white px-4 py-2 rounded hover:bg-[#767CB5]">Registrarse</button>
      </form>
    @else
      <p>Ya tienes una cuenta activa.</p>
    @endif
  </div>
</div>