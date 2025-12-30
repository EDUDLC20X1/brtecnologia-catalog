<!-- Navigation Bar - B&R Tecnología - Sistema Unificado 2025 -->
@php
    $navbarLogo = \App\Models\SiteContent::get('global.navbar_logo');
    $navbarLogoUrl = content_image_url($navbarLogo, 'images/logo-br.png');
    $companyName = \App\Models\SiteContent::get('global.company_name', 'B&R Tecnología');
@endphp

<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

<style>
/* Estilos críticos para menú móvil */
@media (max-width: 991.98px) {
    #navbarMain {
        background: #ffffff !important;
        margin-top: 0.5rem;
        padding: 1.25rem !important;
        border-radius: 12px !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
        border: 1px solid #e2e8f0 !important;
        position: absolute;
        top: 100%;
        left: 10px;
        right: 10px;
        z-index: 1050;
    }
}

/* Asegurar fondo blanco en TODOS los dropdowns */
.dropdown-menu {
    background-color: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}

.dropdown-item {
    background-color: transparent;
    color: #1e293b !important;
}

.dropdown-item:hover, .dropdown-item:focus {
    background: linear-gradient(135deg, #3b82f6 0%, #0ea5e9 100%) !important;
    color: #ffffff !important;
}
</style>

<nav id="mainNavbar" class="navbar navbar-expand-lg navbar-light bg-white sticky-top" style="height: 64px; min-height: 64px; max-height: 64px;">
    <div class="container-xl">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center pe-3" href="{{ route('home') }}" style="height: 48px; overflow: hidden;">
            <img src="{{ $navbarLogoUrl }}" alt="{{ $companyName }}" class="navbar-logo" 
                 style="max-height: 150px; max-width: 150px; width: auto; height: auto; object-fit: contain;"
                 onerror="this.onerror=null; this.src='{{ asset('images/logo-br.png') }}'">
        </a>

        <!-- Toggler Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" 
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-4"></i>
        </button>

        <!-- Menú colapsable -->
        <div class="collapse navbar-collapse" id="navbarMain">
            <!-- Navegación principal - CENTRADA -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                @if(auth()->check() && auth()->user()->isAdmin())
                    {{-- Menú Administrador --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-tools me-1"></i>Gestión
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('products.index') }}"><i class="bi bi-box-seam me-2"></i>Ver Productos</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.create') }}"><i class="bi bi-plus-circle me-2"></i>Crear Producto</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.export') }}"><i class="bi bi-file-earmark-arrow-down me-2"></i>Exportar Productos</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}"><i class="bi bi-tags me-2"></i>Gestionar Categorías</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('admin.content.index') }}"><i class="bi bi-pencil-square me-2"></i>Gestión de Contenido</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.content.section', 'global') }}"><i class="bi bi-image me-2"></i>Configurar Logos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-envelope me-1"></i>Solicitudes
                            @php $pendingCount = \App\Models\ProductRequest::where('status', 'pending')->count(); @endphp
                            @if($pendingCount > 0)<span class="badge bg-danger ms-1">{{ $pendingCount }}</span>@endif
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.requests.index') }}"><i class="bi bi-list-ul me-2"></i>Ver Todas</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.requests.index', ['status' => 'pending']) }}"><i class="bi bi-clock me-2 text-warning"></i>Pendientes</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.quotes.index') }}"><i class="bi bi-receipt me-2"></i>Cotizaciones</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-people me-1"></i>Usuarios
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.users.index') }}"><i class="bi bi-people me-2"></i>Ver Administradores</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.users.create') }}"><i class="bi bi-person-plus me-2"></i>Crear Administrador</a></li>
                        </ul>
                    </li>
                @else
                    {{-- Menú Público --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catalog.index') }}">
                            <i class="bi bi-box-seam me-1"></i>Catálogo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="{{ route('catalog.index', ['on_sale' => 1]) }}">
                            <i class="bi bi-percent me-1"></i>Ofertas
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-tags me-1"></i>Categorías
                        </a>
                        <ul class="dropdown-menu">
                            @foreach(App\Models\Category::limit(8)->get() as $category)
                                <li><a class="dropdown-item" href="{{ route('catalog.index', ['categories' => [$category->id]]) }}">{{ $category->name }}</a></li>
                            @endforeach
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('catalog.index') }}">Ver todos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">
                            <i class="bi bi-info-circle me-1"></i>Acerca de
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">
                            <i class="bi bi-envelope me-1"></i>Contacto
                        </a>
                    </li>
                @endif
            </ul>

            <!-- Sección móvil: búsqueda y cotización -->
            <div class="d-lg-none py-3">
                @if(!auth()->check() || !auth()->user()->isAdmin())
                    <form action="{{ route('catalog.index') }}" method="GET" class="mb-3">
                        <div class="input-group mobile-search">
                            <input type="search" name="search" class="form-control" placeholder="Buscar productos..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                    
                    <a href="{{ route('quote.index') }}" class="btn btn-outline-success w-100 mb-2">
                        <i class="bi bi-cart3 me-1"></i>Mi Cotización
                        <span id="quote-badge-mobile" class="badge bg-danger ms-1" style="display:none;">0</span>
                    </a>
                @endif
                
                @auth
                    {{-- Solo para administradores --}}
                    @if(auth()->user()->isAdmin())
                        <div class="mobile-user-menu">
                            <div class="mobile-user-header mb-3">
                                <i class="bi bi-shield-check text-primary me-2"></i>
                                <span class="fw-bold">{{ auth()->user()->name }}</span>
                            </div>
                            
                            <div class="mobile-user-links">
                                <a href="{{ route('admin.dashboard') }}" class="mobile-user-link">
                                    <i class="bi bi-speedometer2"></i>Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}" class="mobile-user-link">
                                    <i class="bi bi-gear"></i>Configuración
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="mobile-user-link text-danger w-100 text-start border-0 bg-transparent">
                                        <i class="bi bi-box-arrow-right"></i>Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Acciones Desktop -->
        <div class="d-none d-lg-flex align-items-center gap-2" style="margin-top: 4px;">
            @if(!auth()->check() || !auth()->user()->isAdmin())
                <form action="{{ route('catalog.index') }}" method="GET" class="d-flex align-items-center">
                    <div class="search-box">
                        <input type="search" name="search" placeholder="Buscar productos..." value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="btn btn-search-nav">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                
                <a href="{{ route('quote.index') }}" class="btn btn-cart position-relative" title="Mi Cotización">
                    <i class="bi bi-cart3"></i>
                    <span id="quote-badge" class="quote-badge" style="display:none;">0</span>
                </a>
            @endif
            
            @auth
                {{-- Solo para administradores --}}
                @if(auth()->user()->isAdmin())
                    <div class="dropdown">
                        <a class="btn btn-user dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <span class="user-name">{{ Str::limit(auth()->user()->name, 12) }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-header-custom">
                                <i class="bi bi-shield-check text-primary me-2"></i>Administrador
                            </li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-gear me-2"></i>Configuración</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</nav>

<script>
(function(){
    var nav = document.getElementById('mainNavbar');
    if (!nav) return;
    
    function onScroll() {
        nav.classList.toggle('scrolled', window.scrollY > 10);
    }
    
    document.addEventListener('DOMContentLoaded', onScroll);
    window.addEventListener('scroll', onScroll, { passive: true });
    
    function updateQuoteBadge() {
        var badge = document.getElementById('quote-badge');
        var badgeMobile = document.getElementById('quote-badge-mobile');
        
        fetch('{{ route("quote.count") }}', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            var count = data.count || 0;
            [badge, badgeMobile].forEach(function(b) {
                if (b) {
                    b.textContent = count;
                    b.style.display = count > 0 ? 'inline' : 'none';
                }
            });
        })
        .catch(function() {});
    }
    
    document.addEventListener('DOMContentLoaded', updateQuoteBadge);
    window.updateQuoteBadge = updateQuoteBadge;
})();
</script>