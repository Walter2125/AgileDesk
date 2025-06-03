<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Barra principal -->
        <div class="flex items-center justify-between h-16">
            <!-- Izquierda: Sidebar y mensaje -->
            <div class="flex items-center space-x-4">
                <!-- Botón Sidebar -->
                <button class="btn btn-sm btn-light border" onclick="toggleSidebar()">
                    <i class="bi bi-layout-sidebar"></i>
                </button>

                <!-- Mensaje personalizado -->
                <div class="d-none d-sm-block">
                    <div class="text-dark text-truncate fw-bold" style="max-width: 250px; font-size: 1rem;">
                        @yield('mensaje-superior')
                    </div>
                </div>
            </div>

            <!-- Derecha: Enlaces + Dropdown -->
            <div class="flex items-center space-x-6">
                <!-- Enlaces -->
                <div class="flex items-center space-x-6">                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>
                    <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')">
                        Users
                    </x-nav-link>
                </div>                <!-- Información del usuario (opciones en sidebar) -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <div class="text-sm text-gray-600">
                        {{ Auth::user()->name }}
                    </div>
                </div>

                <!-- Botón Hamburguesa (responsive) -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
       
    </div>
</nav>
