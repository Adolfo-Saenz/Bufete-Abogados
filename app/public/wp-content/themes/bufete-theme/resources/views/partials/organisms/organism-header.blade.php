{{-- Header --}}
<section class="h-[80px] bg-[#232536] px-5">
    <div class="flex items-center justify-between h-[80px]">
        <div class="flex items-center space-x-4">
            <img src="{{ Vite::asset('resources/images/logo.jpg') }}" alt="Tu imagen de perfil" class="w-[50px] h-[50px] rounded-full">
            <span class="text-[12px] text-white">Abogados</span>
        </div>
        <div class="flex items-center space-x-15 max-lg:space-x-2">
            <nav class="bg-[#232536] px-1 py-3 relative">
                {{-- Checkbox oculto para toggle --}}
                <input type="checkbox" id="menuToggle" class="peer hidden" />

                {{-- Label como botón hamburguesa --}}
                <label for="menuToggle" class="peer-checked:bg-gray-700 block md:hidden cursor-pointer text-white text-3xl font-bold select-none w-10 h-10 leading-[2.4rem] text-center rounded-md border border-gray-600">
                ☰
                </label>

                {{-- Menú --}}
                <ul class="hidden peer-checked:block md:flex max-lg:space-x-4 lg:space-x-10 mt-3 md:mt-0 text-white font-medium flex-col md:flex-row absolute md:static top-full left-0 w-40 md:w-auto bg-[#232536] md:bg-transparent rounded-md md:rounded-none z-50">
                    <li class="block md:inline bg-gray-700 md:bg-transparent px-3 py-2 md:p-0 border-b border-gray-600 md:border-none cursor-pointer hover:bg-gray-600 md:hover:bg-transparent rounded-md w-full md:w-[75px]">
                        <a href="http://bufete-abogados.local/">Inicio</a>
                    </li>
                    <li class="block md:inline bg-gray-700 md:bg-transparent px-3 py-2 md:p-0 border-b border-gray-600 md:border-none cursor-pointer hover:bg-gray-600 md:hover:bg-transparent rounded-md w-full md:w-[120px]">
                        <a href="#">Sobre nosotros</a>
                    </li>
                    <li class="block md:inline bg-gray-700 md:bg-transparent px-3 py-2 md:p-0 border-b border-gray-600 md:border-none cursor-pointer hover:bg-gray-600 md:hover:bg-transparent rounded-md w-full md:w-[75px]">
                        <a href="#">Abogados</a>
                    </li>
                    <li class="block md:inline bg-gray-700 md:bg-transparent px-3 py-2 md:p-0 border-b border-gray-600 md:border-none cursor-pointer hover:bg-gray-600 md:hover:bg-transparent rounded-md w-full md:w-[90px]">
                        <a href="#">Contáctanos</a>
                    </li>
                </ul>
            </nav>
            <a href="{{ is_user_logged_in() ? '#' : "http://bufete-abogados.local/formulario-de-registro/" }}" class="h-[50px] w-[150px] max-md:w-[130px] bg-white text-[#1e1f36] font-bold rounded-md hover:scale-105 transition-transform duration-200 flex items-center justify-center">
                Área de clientes
            </a>
        </div>
    </div>
</section>