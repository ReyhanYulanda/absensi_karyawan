<div
    x-data="{
        dark: document.documentElement.classList.contains('dark'),
        toggle() {
            this.dark = !this.dark
            document.documentElement.classList.toggle('dark')
            localStorage.theme = this.dark ? 'dark' : 'light'
        }
    }"
>
    <button
        @click="toggle"
        class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700
               text-gray-800 dark:text-gray-200
               hover:bg-gray-300 dark:hover:bg-gray-600
               transition"
        aria-label="Toggle Theme"
    >
        <svg x-show="dark" class="h-5 w-5" viewBox="0 0 24 24" stroke="currentColor" fill="none">
            <path stroke-width="2"
                  d="M12 3v1m0 16v1m8.66-11H21M3 12H2m15.36 6.36l-.7-.7M6.34 6.34l-.7-.7m12.02 0l-.7.7M6.34 17.66l-.7.7M12 8a4 4 0 100 8 4 4 0 000-8z"/>
        </svg>

        <svg x-show="!dark" class="h-5 w-5" viewBox="0 0 24 24" stroke="currentColor" fill="none">
            <path stroke-width="2"
                  d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/>
        </svg>
    </button>
</div>