<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use App\Models\FinanceInternal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private const ADMIN_HMSE_EMAIL = 'admin@hmse.ac.id';
    private const ADMIN_HMSE_PASSWORD = 'adminHMSE2026!';

    // ─── Auth ────────────────────────────────────────
    public function loginSelect()
    {
        return view('pages.auth.login-select');
    }

    public function loginForm(string $role)
    {
        return view('pages.auth.login', compact('role'));
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if ($credentials['email'] === self::ADMIN_HMSE_EMAIL && $credentials['password'] === self::ADMIN_HMSE_PASSWORD) {
            DB::table('roles')->updateOrInsert(
                ['id' => 1],
                [
                    'name' => 'admin',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            DB::table('users')->updateOrInsert(
                ['email' => self::ADMIN_HMSE_EMAIL],
                [
                    'name' => 'Admin HMSE',
                    'email' => self::ADMIN_HMSE_EMAIL,
                    'password' => Hash::make(self::ADMIN_HMSE_PASSWORD),
                    'role_id' => 1,
                    'role' => 'admin',
                    'jabatan' => 'admin',
                    'nim_nip' => null,
                    'divisi' => 'Administrasi',
                    'avatar' => null,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        // Demo accounts are handled in-memory (hardcoded) and do NOT require DB access.
        // Map demo emails to expected passwords and attributes.
        $demoAccounts = [
            // Pengurus group (shared password 'hmse2026')
            'ketua@hmse.ac.id' => ['password' => 'hmse2026', 'name' => 'Ketua HMSE', 'role' => 'pengurus', 'jabatan' => 'ketua_hmse'],
            'wakilketua@hmse.ac.id' => ['password' => 'hmse2026', 'name' => 'Vice President', 'role' => 'pengurus', 'jabatan' => 'vice_president'],
            'sekretaris1@hmse.ac.id' => ['password' => 'hmse2026', 'name' => 'Secretary 1', 'role' => 'pengurus', 'jabatan' => 'sekretaris'],
            'sekretaris2@hmse.ac.id' => ['password' => 'hmse2026', 'name' => 'Secretary 2', 'role' => 'pengurus', 'jabatan' => 'sekretaris'],
            'bendahara1@hmse.ac.id' => ['password' => 'hmse2026', 'name' => 'Finance 1', 'role' => 'pengurus', 'jabatan' => 'bendahara'],
            'bendahara2@hmse.ac.id' => ['password' => 'hmse2026', 'name' => 'Finance 2', 'role' => 'pengurus', 'jabatan' => 'bendahara'],
            'head.akademik@hmse.ac.id' => ['password' => 'hmse2026', 'name' => 'Research and Creativity', 'role' => 'pengurus', 'jabatan' => 'head.akademik'],
            'head.psdm@hmse.ac.id' => ['password' => 'hmse2026', 'name' => 'Resource Management', 'role' => 'pengurus', 'jabatan' => 'head.psdm'],
            'head.humas@hmse.ac.id' => ['password' => 'hmse2026', 'name' => 'Internal and External Communication', 'role' => 'pengurus', 'jabatan' => 'head.humas'],
            'head.mikat@hmse.ac.id' => ['password' => 'hmse2026', 'name' => 'Economy Creative', 'role' => 'pengurus', 'jabatan' => 'head.mikat'],
            'head.medinfo@hmse.ac.id' => ['password' => 'hmse2026', 'name' => 'Creative Media and Information', 'role' => 'pengurus', 'jabatan' => 'head.medinfo'],

            // Pembina / Kaprodi (password 'pembina2026')
            'pembina@ittelkom-pwt.ac.id' => ['password' => 'pembina2026', 'name' => 'Pembina HMSE', 'role' => 'pembina', 'jabatan' => 'pembina'],
            'kaprodi@ittelkom-pwt.ac.id' => ['password' => 'pembina2026', 'name' => 'Kaprodi RPL', 'role' => 'kaprodi', 'jabatan' => 'kaprodi'],
        ];

        if (isset($demoAccounts[$credentials['email']]) && $credentials['password'] === $demoAccounts[$credentials['email']]['password']) {
            // Create an in-memory User model (not persisted) and set it as the authenticated user.
            $demo = $demoAccounts[$credentials['email']];
            $userModel = new \App\Models\User();
            $userModel->id = 0; // sentinel id for demo
            $userModel->name = $demo['name'];
            $userModel->email = $credentials['email'];
            $userModel->role = $demo['role'];
            $userModel->jabatan = $demo['jabatan'];
            $userModel->divisi = $demo['role'] === 'pengurus' ? 'Pengurus' : 'Administrasi';

            \Illuminate\Support\Facades\Auth::login($userModel, $remember);
            $request->session()->regenerate();

            if (in_array($userModel->jabatan, ['pembina', 'kaprodi'])) {
                return redirect()->route('pembina.dashboard')
                    ->with('success', 'Login berhasil! Selamat datang, ' . $userModel->name . '.');
            }

            return redirect()->route('dashboard')
                ->with('success', 'Login berhasil! Selamat datang, ' . $userModel->name . '.');
        }

        if (\Illuminate\Support\Facades\Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = auth()->user();

            // Redirect berdasarkan jabatan user
            if (in_array($user->jabatan, ['pembina', 'kaprodi'])) {
                return redirect()->route('pembina.dashboard')
                    ->with('success', 'Login berhasil! Selamat datang, ' . $user->name . '.');
            }

            return redirect()->route('dashboard')
                ->with('success', 'Login berhasil! Selamat datang, ' . $user->name . '.');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau password salah. Periksa kembali kredensial kamu.']);
    }


    public function logout(Request $request)
    {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }


    // ─── Dashboard Overview ──────────────────────────
    public function index()
    {
        return view('pages.dashboard.index');
    }

    // ─── Kalender ────────────────────────────────────
    public function calendar()
    {
        return view('pages.dashboard.calendar');
    }

    // ─── Proposal ────────────────────────────────────
    public function proposalIndex()
    {
        $proposals = \App\Models\Proposal::latest()->get();
        return view('pages.dashboard.proposal.index', compact('proposals'));
    }

    public function proposalCreate()
    {
        return view('pages.dashboard.proposal.create');
    }

    public function proposalShow(string $id)
    {
        $proposal = \App\Models\Proposal::findOrFail($id);

        // Hitung berapa langkah TTD yang sudah selesai berdasarkan status
        $signedCount = match($proposal->status) {
            'draft'     => 0,
            'reviewing' => 2, // Ketua Panitia + Sekretaris sudah TTD
            'pending'   => 3, // + Ketua HMSE sudah TTD
            'approved'  => 5, // Semua sudah TTD
            'rejected'  => 0,
            default     => 0,
        };

        return view('pages.dashboard.proposal.show', compact('proposal', 'signedCount'));
    }


    public function proposalPreview(string $id)
    {
        try {
            $proposal = \App\Models\Proposal::findOrFail($id);

            // Get SOTK Users
            $sotk = [
                'ketua_hmse' => \App\Models\User::whereIn('jabatan', ['ketua_hmse', 'President'])->first(),
                'sekretaris' => \App\Models\User::whereIn('jabatan', ['sekretaris', 'Secretary 1', 'Secretary 2'])->first(),
                'pembina' => \App\Models\User::where('jabatan', 'pembina')->first(),
                'kaprodi' => \App\Models\User::where('jabatan', 'kaprodi')->first(),
            ];

            // Ambil data approvals (TTD) yang sudah ada, keyed by approver_role
            $approvals = $proposal->approvals()->with('approver')->get()->keyBy('approver_role');

            $isFromForm = false;
            $formData   = null;

            return view('pages.dashboard.proposal.preview', compact('proposal', 'sotk', 'approvals', 'isFromForm', 'formData'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Proposal tidak ditemukan');
        }
    }

    // ─── Keuangan ────────────────────────────────────
    public function financeIndex()
    {
        return view('pages.dashboard.finance.index');
    }

    public function financeInternal()
    {
        return redirect()->route('dashboard.finance.index', ['tab' => 'internal'])
                 ->with('success', 'Laporan berhasil disimpan!');
    }

    public function financeProker()
    {
        return redirect()->route('dashboard.finance.index', ['tab' => 'proker'])
                 ->with('success', 'Laporan berhasil disimpan!');
    }

    // ─── SOTK / Keanggotaan ─────────────────────────
    public function sotkIndex()
    {
        return view('pages.dashboard.sotk.index');
    }

    public function sotkCreate()
    {
        return view('pages.dashboard.sotk.create');
    }

    // ─── Events ──────────────────────────────────────
    public function eventsIndex()
    {
        $events = ProgramKerja::withCount([
            'eventRegistrations as registrations_count' => fn ($q) => $q->whereIn('status', ['pending', 'confirmed']),
        ])->latest()->get();

        return view('pages.dashboard.events.index', compact('events'));
    }

    public function eventRegistrations(string $id)
    {
        $event = ProgramKerja::findOrFail((int) $id);
        $registrations = EventRegistration::where('program_kerja_id', $id)
            ->latest()
            ->paginate(20);

        return view('pages.dashboard.events.registrations', compact('event', 'registrations'));
    }

    public function updateRegistrationStatus(Request $request, string $id, string $regId)
    {
        $registration = EventRegistration::where('program_kerja_id', $id)->findOrFail((int) $regId);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled'],
        ]);

        $registration->update(['status' => $validated['status']]);

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    // ─── Dokumentasi ─────────────────────────────────
    public function documentsIndex()
    {
        return view('pages.dashboard.documents.index');
    }

    // ─── Pengaturan ──────────────────────────────────
    public function settings()
    {
        return view('pages.dashboard.settings');
    }
}
