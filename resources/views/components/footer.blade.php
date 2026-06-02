{{-- resources/views/components/footer.blade.php --}}
<footer class="mt-auto border-t" style="border-color:#e0d9cf; background:#f2ede4;">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            
            {{-- Brand --}}
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:#b8860b;">
                    <i class="ph-fill ph-books text-white text-lg"></i>
                </div>
                <span class="font-display text-lg font-semibold" style="color:#0f0f0f;">
                    Pustaka<span style="color:#b8860b;">Digital</span>
                </span>
            </div>

            {{-- Copyright --}}
            <p class="text-xs text-center md:text-left" style="color:#6b6457;">
                &copy; {{ date('Y') }} PustakaDigital. Semua hak dilindungi.
            </p>

        </div>
    </div>
</footer>