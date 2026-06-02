{{-- resources/views/partials/public-footer.blade.php --}}
<footer class="bg-gray-900 text-white mt-auto">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- Kolom 1: Alamat Kantor & Jam Operasional -->
            <div>
                <!-- Alamat Kantor -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 flex items-center text-blue-400">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Alamat Kantor
                    </h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Jl. KH. Mansyur No. 71, Desa Pangarangan<br>
                        Kec. Kota Sumenep, Kab. Sumenep<br>
                        Jawa Timur 69411
                    </p>
                </div>
                
                <!-- Jam Operasional -->
                <div>
                    <h3 class="text-lg font-semibold mb-3 flex items-center text-blue-400">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Jam Operasional
                    </h3>
                    <div class="space-y-1 text-sm text-gray-400">
                        <p><span class="font-semibold text-white">Senin - Jumat:</span> 08:00 - 15:30</p>
                        <p><span class="font-semibold text-white">Sabtu - Minggu:</span> Libur</p>
                    </div>
                </div>
            </div>
            
            <!-- Kolom 2: Google Maps -->
            <div>
                <h3 class="text-lg font-semibold mb-3 flex items-center text-blue-400">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4" />
                    </svg>
                    Lokasi Kantor
                </h3>
                <div class="rounded-lg overflow-hidden shadow-md">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d247.49835568043548!2d113.8729616262803!3d-7.012376975888297!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd9e4319b614221%3A0xd813f80eb0f2f6de!2sXVQF%2B25W%2C%20Jl.%20K.H.%20Mansyur%20IV%2C%20Podak%2C%20Pabian%2C%20Kec.%20Kota%20Sumenep%2C%20Kabupaten%20Sumenep%2C%20Jawa%20Timur%2069417!5e0!3m2!1sen!2sid!4v1778640647509!5m2!1sen!2sid" 
                        width="100%" 
                        height="180" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="rounded-lg">
                    </iframe>
                </div>
            </div>
            
            <!-- Kolom 3: Hubungi Kami & Ikuti Kami -->
            <div>
                <!-- Hubungi Kami -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 flex items-center text-blue-400">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Hubungi Kami
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex items-start space-x-2">
                            <svg class="h-3.5 w-3.5 text-gray-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="text-gray-400">Email: <a href="mailto:diskominfo@sumenepkab.go.id" class="hover:text-blue-400">diskominfo@sumenepkab.go.id</a></p>
                                <p class="text-gray-400">Faks: (0328) 662635</p>
                                <p class="text-gray-400">WA: <a href="https://wa.me/62818321572" class="hover:text-blue-400">0818321572</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Ikuti Kami (Media Sosial dengan Icon 75% ukuran asli) -->
                <div>
                    <h3 class="text-lg font-semibold mb-3 flex items-center text-blue-400">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Ikuti Kami
                    </h3>
                    <p><span class="font-semibold text-white">Kominfo Sumenep</span></p>
                    <div class="flex flex-wrap gap-3">
                        <!-- YouTube -->
                        <a href="#" target="_blank" class="text-gray-400 hover:text-red-600 transition" title="YouTube">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.376.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.376-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                        <!-- TikTok -->
                        <a href="#" target="_blank" class="text-gray-400 hover:text-black transition" title="TikTok">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                            </svg>
                        </a>
                        <!-- Twitter / X -->
                        <a href="#" target="_blank" class="text-gray-400 hover:text-blue-400 transition" title="Twitter / X">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                        <!-- Facebook -->
                        <a href="#" target="_blank" class="text-gray-400 hover:text-maroon-700 transition" title="Facebook">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                            </svg>
                        </a>
                        <!-- Instagram -->
                        <a href="#" target="_blank" class="text-gray-400 hover:text-pink-500 transition" title="Instagram">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                            </svg>
                        </a>
                        <!-- Gmail -->
                        <a href="#" target="_blank" class="text-gray-400 hover:text-red-500 transition" title="Gmail">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </a>
                        <!-- WhatsApp -->
                        <a href="#" target="_blank" class="text-gray-400 hover:text-green-500 transition" title="WhatsApp">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-5.46-4.45-9.91-9.91-9.91zm0 15.67c-1.44 0-2.84-.38-4.06-1.09l-.29-.17-3.12.82.84-3.04-.19-.3c-.77-1.22-1.17-2.63-1.17-4.06 0-4.27 3.48-7.76 7.76-7.76 4.27 0 7.76 3.48 7.76 7.76.01 4.28-3.47 7.76-7.75 7.76z"/>
                                <path d="M17.03 14.5c-.14-.23-.52-.37-1.09-.65-.57-.28-3.37-1.67-3.89-1.86-.52-.19-.9-.28-1.28.28-.38.56-1.47 1.83-1.8 2.21-.33.38-.66.43-1.23.14-.57-.28-2.41-1.33-2.95-1.86-.54-.53-.54-1.23-.12-1.92.42-.69 1.62-1.91 1.62-1.91s.57-.95.33-1.52c-.24-.56-1.33-3.18-1.82-4.26-.48-1.08-.96-.87-1.32-.87-.28 0-.86-.05-1.32-.05-.46 0-1.17.18-1.78.88-.61.7-2.33 2.28-2.33 5.56 0 3.28 2.39 6.46 2.72 6.91.33.45 4.7 7.18 11.38 5.46 1.15-.3 2.06-1.07 2.73-2.07.67-1 .86-1.94.61-2.69-.24-.75-1.04-1.2-1.19-1.33z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Kolom 4: Tim Pengembang -->
            <div>
                <h3 class="text-lg font-semibold mb-3 flex items-center text-blue-400">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Tim Pengembang
                </h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Tim Pengembang Aplikasi<br>
                    Bidang Informasi dan Komunikasi Publik (IKP)<br>
                    Dinas Komunikasi dan Informatika<br>
                    Kabupaten Sumenep
                </p>
                <div class="mt-4 pt-3 border-t border-gray-800">
                    <p class="text-gray-500 text-sm">
                        <span class="text-gray-400">Versi Aplikasi:</span> 1.0.0
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Copyright -->
    <div class="border-t border-gray-800 mt-4 pt-5 pb-6 text-center">
        <div class="container mx-auto px-4">
            <p class="text-sm text-gray-500">
                &copy; {{ date('Y') }} PPID Kabupaten Sumenep - Pejabat Pengelola Informasi dan Dokumentasi
            </p>
            <p class="text-sm text-gray-600 mt-1">
                Dinas Komunikasi dan Informatika Kabupaten Sumenep
            </p>
        </div>
    </div>
</footer>