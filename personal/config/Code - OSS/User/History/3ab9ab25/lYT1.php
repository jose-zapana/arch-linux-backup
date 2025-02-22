<footer class="divide-y bg-[#212B38] text-gray-800 mt-32 shadow-xl">

    <div
        class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-6 flex flex-col justify-between py-10 space-y-8 lg:flex-row lg:space-y-0 text-gray-300">
        <div class="lg:w-1/3">
            <a href="/">
                <div class="flex justify-center p-2">
                    <img class="aspect-[1/1]  w-32 h-32" src="{{ asset('img/logo.png') }}" alt="Logo Pc-Hard" />

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
                        <a href="/contact" data-turbo="false">Contáctanos</a>
                    </li>
                </ul>
            </div>

            <div class="space-y-3">
                <h3 class="tracking-wide uppercase text-white">Compañía</h3>
                <ul class="space-y-1">
                    <li>
                        <a href="/privacy-policy" data-turbo="false">Politicas y Privacidad</a>
                    </li>
                    <li>
                        <a href="/terms-of-service" data-turbo="false">Terminos y condiciones</a>
                    </li>

                    <li>
                        <a href="/data-protection" data-turbo="false">Protección de datos</a>
                    </li>

                    <li>
                        <a href="/warranty-policies" data-turbo="false">Política de
                            garantía</a>
                    </li>
                </ul>
            </div>

            <div class="space-y-3">
                <h3 class="uppercase text-white">Servicios</h3>
                <ul class="space-y-1">
                    <li>
                        <a href="#" data-turbo="false">Diseño web</a>
                    </li>
                    <li>
                        <a href="#" data-turbo="false">Asesorías</a>
                    </li>
                </ul>
            </div>

            <div class="space-y-3">
                <div class="uppercase text-white">Social media</div>
                <div class="flex justify-start space-x-3">
                    <a data-turbo="false" onclick="fbq('trackCustom', 'VisitaFacebook');"
                        href="https://www.facebook.com/pc.hard.technology/" target="_blank" title="Facebook"
                        class="flex items-center p-1">
                        <i class="fab fa-facebook text-2xl"></i>
                    </a>
                    <a data-turbo="false" onclick="fbq('trackCustom', 'VisitaTiktok');"
                        href="https://www.tiktok.com/@pc.hard" target="_blank" title="Tiktok"
                        class="flex items-center p-1">
                        <i class="fab fa-tiktok text-2xl"></i>
                    </a>

                </div>
            </div>
        </div>
    </div>
    <div class="py-4 text-sm text-center text-gray-200 ">
        © 2024 PC-Hard Technology. Todos los derechos reservados.
    </div>

    <!-- Boton WhatsApp -->
    <script src="{{ asset('landing/assets/js/fgp_wa.js') }}"></script>

</footer>
