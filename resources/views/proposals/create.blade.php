@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-black text-gray-800 mb-2">Buat Proposal Baru</h1>
                <p class="text-gray-600">Isi formulir di bawah untuk membuat proposal kegiatan</p>
            </div>

            <!-- Form -->
            <form action="{{ route('proposals.store') }}" method="POST" class="space-y-8">
                @csrf

                <input type="hidden" name="proker_id" value="{{ request()->query('proker_id') }}">

                <!-- Title -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-600">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Proposal <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                        placeholder="Contoh: Acara Gathering HMSE 2024"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                        required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Risk Level -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-600">
                    <label for="risk_level" class="block text-sm font-semibold text-gray-700 mb-3">
                        Tingkat Risiko <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-3">
                        @foreach ($riskLevels as $value => $label)
                            <label
                                class="flex items-start gap-3 p-3 border-2 rounded-lg cursor-pointer transition hover:bg-gray-50"
                                style="{{ old('risk_level') === $value ? 'border-color: #2C3DA6; background-color: #f8f9fb;' : 'border-color: #e5e7eb;' }}">
                                <input type="radio" name="risk_level" value="{{ $value }}"
                                    {{ old('risk_level') === $value ? 'checked' : '' }} required class="mt-1">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $label }}</p>
                                    <p class="text-sm text-gray-600">
                                        @if ($value === 'low')
                                            Risiko minimal, perlu persetujuan dari ketua panitia dan sekretaris
                                        @else
                                            Risiko tinggi, perlu persetujuan dari semua 5 pihak
                                        @endif
                                    </p>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('risk_level')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Background -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-600">
                    <label for="background" class="block text-sm font-semibold text-gray-700 mb-2">
                        Latar Belakang <span class="text-red-500">*</span>
                    </label>
                    <textarea id="background" name="background" rows="5"
                        placeholder="Jelaskan latar belakang mengapa kegiatan ini perlu dilaksanakan..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                        required>{{ old('background') }}</textarea>
                    @error('background')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Objective -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-600">
                    <label for="objective" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tujuan Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="objective" name="objective" rows="5"
                        placeholder="Jelaskan tujuan atau goal yang ingin dicapai dari kegiatan ini..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                        required>{{ old('objective') }}</textarea>
                    @error('objective')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Risk Description -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-600">
                    <label for="risk_description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Identifikasi & Mitigasi Risiko <span class="text-red-500">*</span>
                    </label>
                    <textarea id="risk_description" name="risk_description" rows="5"
                        placeholder="Jelaskan potensi risiko yang mungkin terjadi dan bagaimana cara mengantisipasi/mengatasi risiko tersebut..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                        required>{{ old('risk_description') }}</textarea>
                    @error('risk_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Budget -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-600">
                    <label for="budget" class="block text-sm font-semibold text-gray-700 mb-2">
                        Anggaran (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="budget" name="budget" value="{{ old('budget') }}" min="0"
                        step="1000" placeholder="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                        required>
                    @error('budget')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Timeline -->
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-600">
                    <label for="timeline" class="block text-sm font-semibold text-gray-700 mb-2">
                        Timeline Pelaksanaan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="timeline" name="timeline" value="{{ old('timeline') }}"
                        placeholder="Contoh: 15 Januari - 20 Januari 2024"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                        required>
                    @error('timeline')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <a href="{{ route('proposals.index') }}"
                        class="px-6 py-2 border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">
                        Simpan Proposal
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
