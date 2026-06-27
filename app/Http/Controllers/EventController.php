<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Daftar event/proker yang dipublikasikan ke halaman News.
     */
    public function index(Request $request)
    {
        $search   = $request->get('search', '');
        $division = $request->get('division', '');
        $status   = $request->get('status', '');

        $query = ProgramKerja::where('is_public', true)
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%"))
            ->when($division, fn ($q) => $q->where('division', $division))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderBy('date_start', 'asc');

        $events = $query->paginate(9)->withQueryString();

        $divisions = ProgramKerja::where('is_public', true)
            ->distinct()
            ->pluck('division')
            ->sort()
            ->values();

        return view('pages.news.index', compact('events', 'search', 'division', 'status', 'divisions'));
    }

    /**
     * Detail satu event.
     */
    public function show(string $id)
    {
        $event = ProgramKerja::where('is_public', true)
            ->findOrFail((int) $id);

        $registrationCount = $event->eventRegistrations()->whereIn('status', ['pending', 'confirmed'])->count();

        $quota = $event->registration_quota ?? $event->target_participants;
        $isFull = $quota && $registrationCount >= $quota;

        $isOpen = $event->open_registration
            && !$isFull
            && (!$event->registration_deadline || now()->lte($event->registration_deadline));

        return view('pages.news.show', compact('event', 'registrationCount', 'quota', 'isFull', 'isOpen'));
    }

    /**
     * Simpan pendaftaran peserta.
     */
    public function register(Request $request, string $id)
    {
        $event = ProgramKerja::where('is_public', true)
            ->where('open_registration', true)
            ->findOrFail((int) $id);

        // Cek quota
        $registrationCount = $event->eventRegistrations()->whereIn('status', ['pending', 'confirmed'])->count();
        $quota = $event->registration_quota ?? $event->target_participants;
        if ($quota && $registrationCount >= $quota) {
            return back()->withErrors(['quota' => 'Maaf, kuota pendaftaran sudah penuh.'])->withInput();
        }

        // Cek deadline
        if ($event->registration_deadline && now()->gt($event->registration_deadline)) {
            return back()->withErrors(['deadline' => 'Maaf, batas waktu pendaftaran sudah lewat.'])->withInput();
        }

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'nim'      => ['nullable', 'string', 'max:50'],
            'email'    => ['required', 'email', 'max:255'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'prodi'    => ['nullable', 'string', 'max:150'],
            'semester' => ['nullable', 'string', 'max:10'],
            'note'     => ['nullable', 'string', 'max:1000'],
        ]);

        // Cek apakah email sudah daftar di event ini
        $existing = EventRegistration::where('program_kerja_id', $event->id)
            ->where('email', $validated['email'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($existing) {
            return back()->withErrors(['email' => 'Email ini sudah terdaftar pada event ini.'])->withInput();
        }

        EventRegistration::create([
            'program_kerja_id' => $event->id,
            'name'             => $validated['name'],
            'nim'              => $validated['nim'] ?? null,
            'email'            => $validated['email'],
            'phone'            => $validated['phone'] ?? null,
            'prodi'            => $validated['prodi'] ?? null,
            'semester'         => $validated['semester'] ?? null,
            'note'             => $validated['note'] ?? null,
            'status'           => 'pending',
            'token'            => Str::random(64),
        ]);

        return redirect()
            ->route('events.show', $event->id)
            ->with('success', 'Pendaftaran berhasil! Kami akan menghubungi kamu melalui email yang terdaftar.');
    }
}
