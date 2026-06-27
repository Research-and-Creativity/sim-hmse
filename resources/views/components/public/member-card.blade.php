@props([
    'nama' => 'Nama Anggota',
    'jabatan' => 'Jabatan',
    'foto' => null,
    'fotoPosition' => 'center',
    'instagram' => null,
    'linkedin' => null,
    'email' => null,
])

<div class="group flex flex-col items-center text-center bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">

    {{-- Foto Profil --}}
    <div class="relative mb-4">
        <div class="w-20 h-20 rounded-2xl overflow-hidden bg-gradient-to-br from-[#1e3a5f]/10 to-[#2e86ab]/20 shadow-sm">
            @if($foto)
                <img
                    src="{{ asset($foto) }}"
                    alt="{{ $nama }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    style="object-position: {{ $fotoPosition }};"
                    loading="lazy"
                >
            @else
                {{-- Placeholder Avatar --}}
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#1e3a5f] to-[#2e86ab]">
                    <span class="text-2xl font-black text-white uppercase">
                        {{ mb_substr($nama, 0, 1) }}
                    </span>
                </div>
            @endif
        </div>

        {{-- Online indicator dot --}}
        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-[#f4a261] rounded-full border-2 border-white"></div>
    </div>

    {{-- Info --}}
    <div class="flex-1 w-full">
        <h4 class="text-sm font-bold text-[#1e3a5f] leading-tight line-clamp-2 mb-1">
            {{ $nama }}
        </h4>
        <p class="text-xs text-[#2e86ab] font-semibold bg-[#2e86ab]/10 px-2 py-0.5 rounded-full inline-block">
            {{ $jabatan }}
        </p>
    </div>

    {{-- Social Media Links --}}
    @if($instagram || $linkedin || $email)
        <div class="flex items-center justify-center gap-2 mt-3 pt-3 border-t border-gray-100 w-full">

            @if($instagram)
                <a href="https://instagram.com/{{ $instagram }}"
                   target="_blank"
                   class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-pink-100 flex items-center justify-center transition-colors duration-200 group/icon"
                   title="Instagram @{{ $instagram }}">
                    <svg class="w-3.5 h-3.5 text-gray-400 group-hover/icon:text-pink-500 transition-colors duration-200" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
            @endif

            @if($linkedin)
                <a href="https://linkedin.com/in/{{ $linkedin }}"
                   target="_blank"
                   class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-blue-100 flex items-center justify-center transition-colors duration-200 group/icon"
                   title="LinkedIn">
                    <svg class="w-3.5 h-3.5 text-gray-400 group-hover/icon:text-blue-600 transition-colors duration-200" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </a>
            @endif

            @if($email)
                <a href="mailto:{{ $email }}"
                   class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-[#2e86ab]/20 flex items-center justify-center transition-colors duration-200 group/icon"
                   title="{{ $email }}">
                    <svg class="w-3.5 h-3.5 text-gray-400 group-hover/icon:text-[#2e86ab] transition-colors duration-200" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                    </svg>
                </a>
            @endif

        </div>
    @endif

</div>
