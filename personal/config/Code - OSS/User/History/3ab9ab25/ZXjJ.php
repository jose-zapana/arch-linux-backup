<footer class="divide-y bg-[#212B38] text-gray-800 mt-32 shadow-xl">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-6 flex flex-col justify-between py-10 space-y-8 lg:flex-row lg:space-y-0 text-gray-300">
        <div class="lg:w-1/3">
            <a href="/">
                <div class="flex justify-center p-2">
                    <img class="aspect-[1/1] w-32 h-32" src="{{ asset('img/logo-pchard.webp') }}" alt="Logo Pc-Hard" />
                </div>
                <div class="flex justify-center">
                    <h2 class="text-lg font-bold text-gray-200 grid-cols-1">
                        PCHARD S.A.C | 20610015213
                    </h2>
                </div>
            </a>
        </div>
        <div class="grid grid-cols-2 text-sm gap-x-3 gap-y-8 lg:w-2/3 sm:grid-cols-4">
            <div class="space-y-3">
                <h3 class="tracking-wide uppercase text-white">Nosotros</h3>
                <ul class="space-y-1">
                    <li>
                        <a href="https://api.whatsapp.com/send/?phone=51957686487&text=Hola%21+Escribo+desde+la+web+de+pc-hard.com&type=phone_number&app_absent=0" 
                           data-turbo="false" 
                           aria-label="Contacta a PC-Hard Technology a través de WhatsApp">
                           Contáctanos
                        </a>
                    </li>
                </ul>
            </div>
            <div class="space-y-3">
                <h3 class="tracking-wide uppercase text-white">Compañía</h3>
                <ul class="space-y-1">
                    <li>
                        <a href="/privacy-policy" data-turbo="false" aria-label="Políticas y privacidad de PC-Hard Technology">Políticas y Privacidad</a>
                    </li>
                    <li>
                        <a href="/terms-of-service" data-turbo="false" aria-label="Términos y condiciones de PC-Hard Technology">Términos y condiciones</a>
                    </li>
                    <li>
                        <a href="/data-protection" data-turbo="false" aria-label="Política de protección de datos de PC-Hard Technology">Protección de datos</a>
                    </li>
                    <li>
                        <a href="/warranty-policies" data-turbo="false" aria-label="Política de garantía de PC-Hard Technology">Política de garantía</a>
                    </li>
                </ul>
            </div>
            <div class="space-y-3">
                <h3 class="uppercase text-white">Servicios</h3>
                <ul class="space-y-1">
                    <li>
                        <a href="#" data-turbo="false" aria-label="Servicio de diseño web de PC-Hard Technology">Diseño web</a>
                    </li>
                    <li>
                        <a href="#" data-turbo="false" aria-label="Servicios de asesorías de PC-Hard Technology">Asesorías</a>
                    </li>
                </ul>
            </div>
            <div class="space-y-3">
                <div class="uppercase text-white">Social media</div>
                <div class="flex justify-start space-x-3">
                    <a data-turbo="false" onclick="fbq('trackCustom', 'VisitaFacebook');"
                        href="https://www.facebook.com/pc.hard.technology/" target="_blank" 
                        title="Visita nuestra página de Facebook" 
                        class="flex items-center p-1" 
                        aria-label="Ir a la página de Facebook de PC-Hard Technology">
                        <i class="fab fa-facebook text-2xl"></i>
                    </a>
                    <a data-turbo="false" onclick="fbq('trackCustom', 'VisitaTiktok');"
                        href="https://www.tiktok.com/@pc.hard" target="_blank" 
                        title="Visita nuestra página de TikTok" 
                        class="flex items-center p-1" 
                        aria-label="Ir a la página de TikTok de PC-Hard Technology">
                        <i class="fab fa-tiktok text-2xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="py-4 text-sm text-center text-gray-200">
        © 2024 PC-Hard Technology. Todos los derechos reservados.
    </div>

    <!-- Boton WhatsApp -->
    <script src="{{ asset('landing/assets/js/fgp_wa.js') }}"></script>
</footer>
