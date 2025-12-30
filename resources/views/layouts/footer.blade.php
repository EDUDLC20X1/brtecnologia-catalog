<footer class="footer-clean">
    @php
        // Obtener información de contacto desde el CMS
        $contactPhone = \App\Models\SiteContent::get('contact.phone', '+593 98 863 3454');
        $contactAddress = \App\Models\SiteContent::get('contact.address', 'Machala, Ecuador');
        $contactHours = \App\Models\SiteContent::get('contact.hours', 'Lun - Vie: 08:00 - 18:00');
        $adminEmail = \App\Services\AdminService::getAdminEmail();
        
        // Número de WhatsApp (extraer solo dígitos del teléfono)
        $whatsappNumber = preg_replace('/[^0-9]/', '', $contactPhone);
        
        // Logo del footer desde CMS
        $footerLogo = \App\Models\SiteContent::get('global.logo_white');
        $footerLogoUrl = content_image_url($footerLogo, 'images/logo-white.png');
        
        // Redes sociales desde CMS
        $socialFacebook = \App\Models\SiteContent::get('contact.social_facebook', 'https://facebook.com');
        $socialInstagram = \App\Models\SiteContent::get('contact.social_instagram', 'https://instagram.com');
        $socialTwitter = \App\Models\SiteContent::get('contact.social_twitter', 'https://twitter.com');
    @endphp
    
    <div class="container">
        <div class="footer-content">
            <div class="row g-4 g-lg-5">
                <!-- Logo y descripción -->
                <div class="col-lg-3 col-md-6">
                    <div class="footer-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/logo-br.png') }}" 
                                 alt="B&R Tecnología" 
                                 class="footer-logo">
                        </a>
                        <p class="footer-desc">
                            Su herramienta de trabajo en las mejores manos. Somos su aliado tecnológico de confianza.
                        </p>
                        <div class="social-links">
                            @if($socialFacebook)
                                <a href="{{ $socialFacebook }}" target="_blank" rel="noopener" title="Facebook">
                                    <i class="bi bi-facebook"></i>
                                </a>
                            @endif
                            @if($socialInstagram)
                                <a href="{{ $socialInstagram }}" target="_blank" rel="noopener" title="Instagram">
                                    <i class="bi bi-instagram"></i>
                                </a>
                            @endif
                            @if($socialTwitter)
                                <a href="{{ $socialTwitter }}" target="_blank" rel="noopener" title="Twitter">
                                    <i class="bi bi-twitter"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Productos -->
                <div class="col-lg-3 col-md-6 col-6">
                    <h6 class="footer-title">Productos</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('catalog.index') }}">Todos los Productos</a></li>
                        <li><a href="{{ route('catalog.index', ['on_sale' => 1]) }}">Ofertas Especiales</a></li>
                    </ul>
                </div>

                <!-- Categorías -->
                <div class="col-lg-3 col-md-6 col-6">
                    <h6 class="footer-title">Categorías</h6>
                    <ul class="footer-links">
                        @foreach(App\Models\Category::limit(5)->get() as $category)
                            <li>
                                <a href="{{ route('catalog.index', ['categories' => [$category->id]]) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                        <li><a href="{{ route('catalog.index') }}">Ver más →</a></li>
                    </ul>
                </div>

                <!-- Contacto -->
                <div class="col-lg-3 col-md-6">
                    <h6 class="footer-title">Contacto</h6>
                    <ul class="footer-contact">
                        <li>
                            <i class="bi bi-telephone"></i>
                            <a href="tel:{{ $contactPhone }}">{{ $contactPhone }}</a>
                        </li>
                        <li>
                            <i class="bi bi-envelope"></i>
                            <a href="mailto:{{ $adminEmail }}">{{ $adminEmail }}</a>
                        </li>
                        <li>
                            <i class="bi bi-geo-alt"></i>
                            <span>{{ $contactAddress }}</span>
                        </li>
                        <li>
                            <i class="bi bi-clock"></i>
                            <span>{{ $contactHours }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>© {{ date('Y') }} <strong>B&R Tecnología</strong>. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<!-- WhatsApp Button -->
<a href="https://wa.me/{{ $whatsappNumber }}?text=Hola%2C%20estoy%20interesado%20en%20sus%20productos" class="whatsapp-float" target="_blank" title="Contáctanos por WhatsApp">
    <div class="whatsapp-pulse"></div>
    <i class="bi bi-whatsapp"></i>
</a>

<style>
/* ============================================
   FOOTER CLEAN - B&R Tecnología 2025
   ============================================ */

.footer-clean {
    background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
    color: #e2e8f0;
    padding-top: 3rem;
}

.footer-content {
    padding-bottom: 2rem;
}

/* Brand Section */
.footer-brand {
    max-width: 280px;
}

.footer-logo {
    height: 45px;
    width: auto;
    max-width: 160px;
    object-fit: contain;
    margin-bottom: 1rem;
}

.footer-desc {
    font-size: 0.9rem;
    line-height: 1.6;
    color: #94a3b8;
    margin-bottom: 1.25rem;
}

/* Social Links */
.social-links {
    display: flex;
    gap: 0.5rem;
}

.social-links a {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 50%;
    color: #94a3b8;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.social-links a:hover {
    background: #5eead4;
    border-color: #5eead4;
    transform: translateY(-2px);
    color: #0f172a;
}

/* Footer Titles */
.footer-title {
    color: #ffffff;
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 1.25rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Footer Links */
.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 0.6rem;
}

.footer-links a {
    color: #94a3b8;
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.2s ease;
}

.footer-links a:hover {
    color: #5eead4;
}

/* Footer Contact */
.footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-contact li {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    font-size: 0.9rem;
}

.footer-contact li i {
    color: #5eead4;
    font-size: 1rem;
    width: 18px;
}

.footer-contact a {
    color: #94a3b8;
    text-decoration: none;
    transition: color 0.2s ease;
}

.footer-contact a:hover {
    color: #5eead4;
}

.footer-contact span {
    color: #94a3b8;
}

/* Footer Bottom */
.footer-bottom {
    padding: 1.25rem 0;
    border-top: 1px solid rgba(255,255,255,0.1);
    text-align: center;
}

.footer-bottom p {
    color: #64748b;
    font-size: 0.85rem;
    margin: 0;
}

.footer-bottom strong {
    color: #5eead4;
}

/* WhatsApp Button */
.whatsapp-float {
    position: fixed;
    bottom: 25px;
    right: 25px;
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.6rem;
    box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
    transition: all 0.3s ease;
    z-index: 1000;
}

.whatsapp-float:hover {
    transform: scale(1.08);
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.5);
    color: white;
}

.whatsapp-pulse {
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: inherit;
    animation: wa-pulse 2s infinite;
    z-index: -1;
}

@keyframes wa-pulse {
    0% { transform: scale(1); opacity: 0.6; }
    100% { transform: scale(1.4); opacity: 0; }
}

/* Responsive */
@media (max-width: 991.98px) {
    .footer-brand {
        max-width: 100%;
        text-align: center;
        margin: 0 auto 1.5rem;
    }
    
    .footer-logo {
        margin: 0 auto 1rem;
        display: block;
    }
    
    .social-links {
        justify-content: center;
    }
}

@media (max-width: 767.98px) {
    .footer-clean {
        padding-top: 2rem;
    }
    
    .footer-title {
        margin-bottom: 1rem;
    }
    
    .footer-contact li {
        justify-content: flex-start;
    }
    
    .whatsapp-float {
        bottom: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        font-size: 1.4rem;
    }
}
</style>
