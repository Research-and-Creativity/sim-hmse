<x-layouts.dashboard title="Error - Preview Proposal">

    <div class="flex items-center justify-center min-h-screen">
        <div class="max-w-md mx-auto text-center">
            <div class="mb-4">
                <svg class="w-16 h-16 mx-auto text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Terjadi Kesalahan</h2>
            <p class="text-gray-600 mb-6">{{ $message }}</p>
            <a href="{{ route('dashboard.proposal.index') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Kembali ke Proposal
            </a>
        </div>
    </div>

</x-layouts.dashboard>
