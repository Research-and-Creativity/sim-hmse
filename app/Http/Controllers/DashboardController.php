<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\ProgramKerja;
use App\Models\Proposal;
use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Models\FinanceInternal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        // Demo accounts
        $demoAccounts = [
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
            'pembina@ittelkom-pwt.ac.id' => ['password' => 'pembina2026', 'name' => 'Pembina HMSE', 'role' => 'pembina', 'jabatan' => 'pembina'],
            'kaprodi@ittelkom-pwt.ac.id' => ['password' => 'pembina2026', 'name' => 'Kaprodi RPL', 'role' => 'kaprodi', 'jabatan' => 'kaprodi'],
        ];

        if (isset($demoAccounts[$credentials['email']]) && $credentials['password'] === $demoAccounts[$credentials['email']]['password']) {
            $demo = $demoAccounts[$credentials['email']];
            $userModel = User::updateOrCreate(
                ['email' => $credentials['email']],
                [
                    'name' => $demo['name'],
                    'password' => Hash::make($demo['password']),
                    'role_id' => $demo['role'] === 'pengurus' ? 2 : 1,
                    'role' => $demo['role'],
                    'jabatan' => $demo['jabatan'],
                    'divisi' => $demo['role'] === 'pengurus' ? 'Pengurus' : 'Administrasi',
                ]
            );

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
        $totalProker = ProgramKerja::count();
        $proposalAktif = Proposal::whereIn('status', ['draft', 'reviewing', 'pending'])->count();
        $internalIn = FinanceInternal::where('type', 'income')->sum('amount');
        $internalOut = FinanceInternal::where('type', 'outcome')->sum('amount');
        $saldoKas = $internalIn - $internalOut;
        $totalPengurus = User::whereIn('role', ['pengurus', 'admin'])->count();

        $prokerTerbaru = ProgramKerja::latest()->take(5)->get();
        $upcomingEvents = ProgramKerja::whereNotNull('date_start')
            ->orderBy('date_start', 'asc')
            ->take(5)
            ->get();

        $recentActivities = collect();
        
        Proposal::latest()->take(3)->get()->each(function ($prop) use ($recentActivities) {
            $recentActivities->push([
                'icon' => 'doc',
                'color' => 'purple',
                'text' => 'Proposal "' . $prop->title . '" (' . ucfirst($prop->status) . ')',
                'time' => $prop->created_at->diffForHumans(),
                'created_at' => $prop->created_at,
            ]);
        });

        FinanceInternal::latest()->take(3)->get()->each(function ($tx) use ($recentActivities) {
            $recentActivities->push([
                'icon' => 'upload',
                'color' => 'emerald',
                'text' => 'Transaksi kas "' . $tx->title . '" (Rp ' . number_format($tx->amount, 0, ',', '.') . ')',
                'time' => $tx->created_at->diffForHumans(),
                'created_at' => $tx->created_at,
            ]);
        });

        ProgramKerja::latest()->take(3)->get()->each(function ($pk) use ($recentActivities) {
            $recentActivities->push([
                'icon' => 'check',
                'color' => 'blue',
                'text' => 'Program kerja "' . $pk->name . '" tercatat',
                'time' => $pk->created_at->diffForHumans(),
                'created_at' => $pk->created_at,
            ]);
        });

        $recentActivities = $recentActivities->sortByDesc('created_at')->take(5)->values();

        return view('pages.dashboard.index', compact(
            'totalProker',
            'proposalAktif',
            'saldoKas',
            'totalPengurus',
            'prokerTerbaru',
            'upcomingEvents',
            'recentActivities'
        ));
    }

    // ─── Kalender ────────────────────────────────────
    public function calendar()
    {
        $calendarEvents = ProgramKerja::whereNotNull('date_start')
            ->get()
            ->map(function ($p) {
                return [
                    'title' => $p->name,
                    'date' => optional($p->date_start)->format('Y-m-d'),
                    'color' => $p->color ?: '#2C3DA6',
                    'divisi' => $p->division,
                ];
            });

        return view('pages.dashboard.calendar', compact('calendarEvents'));
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

        $signedCount = match($proposal->status) {
            'draft'     => 0,
            'reviewing' => 2,
            'pending'   => 3,
            'approved'  => 5,
            'rejected'  => 0,
            default     => 0,
        };

        return view('pages.dashboard.proposal.show', compact('proposal', 'signedCount'));
    }

    public function proposalPreview(string $id)
    {
        try {
            $proposal = \App\Models\Proposal::findOrFail($id);

            $sotk = [
                'ketua_hmse' => \App\Models\User::whereIn('jabatan', ['ketua_hmse', 'President'])->first(),
                'sekretaris' => \App\Models\User::whereIn('jabatan', ['sekretaris', 'Secretary 1', 'Secretary 2'])->first(),
                'pembina' => \App\Models\User::where('jabatan', 'pembina')->first(),
                'kaprodi' => \App\Models\User::where('jabatan', 'kaprodi')->first(),
            ];

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
        $allMembers = User::whereIn('role', ['pengurus', 'admin'])
            ->orderBy('divisi')
            ->orderBy('name')
            ->get();

        $membersByDivision = $allMembers->groupBy(function ($user) {
            return $user->divisi ?: 'Lainnya';
        });

        $president = User::whereIn('jabatan', ['ketua_hmse', 'President'])->first();
        $vicePresident = User::whereIn('jabatan', ['wakil_ketua_hmse', 'Vice President'])->first();
        $pembina = User::where('jabatan', 'pembina')->first();
        $kaprodi = User::where('jabatan', 'kaprodi')->first();

        return view('pages.dashboard.sotk.index', compact(
            'allMembers',
            'membersByDivision',
            'president',
            'vicePresident',
            'pembina',
            'kaprodi'
        ));
    }

    public function sotkCreate()
    {
        $divisionOptions = [
            'Pimpinan Inti',
            'Resource Management',
            'Internal and External Communication',
            'Research and Creativity',
            'Economy Creative',
            'Creative Media and Information',
        ];

        return view('pages.dashboard.sotk.create', compact('divisionOptions'));
    }

    public function sotkStore(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-Z\s\.\']+$/'],
            'nim' => ['required', 'numeric', 'digits_between:8,15'],
            'divisi' => ['required', 'string', 'max:150'],
            'jabatan' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:20'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.min' => 'Nama lengkap minimal 3 karakter.',
            'name.regex' => 'Nama lengkap hanya boleh berisi huruf, titik, spasi, atau tanda petik.',
            'nim.required' => 'NIM wajib diisi.',
            'nim.numeric' => 'NIM harus berupa angka.',
            'nim.digits_between' => 'NIM harus terdiri dari 8 hingga 15 digit angka.',
            'divisi.required' => 'Divisi wajib dipilih.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar oleh pengguna lain.',
            'phone.regex' => 'Format nomor HP / WhatsApp tidak valid.',
            'avatar.image' => 'File foto profil harus berupa gambar.',
            'avatar.mimes' => 'Format foto profil harus JPG, JPEG, atau PNG.',
            'avatar.max' => 'Ukuran foto profil maksimal 2MB.',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars');
        }

        $email = $validated['email'] ?? ($validated['nim'] . '@hmse.local');
        
        $counter = 1;
        while (User::where('email', $email)->exists()) {
            $email = $validated['nim'] . '_' . $counter . '@hmse.local';
            $counter++;
        }

        $temporaryPassword = 'Hmse.' . Str::lower(Str::random(6));

        $user = User::create([
            'name' => $validated['name'],
            'email' => $email,
            'password' => Hash::make($temporaryPassword),
            'role' => 'pengurus',
            'role_id' => 2,
            'jabatan' => $validated['jabatan'],
            'nim_nip' => $validated['nim'],
            'divisi' => $validated['divisi'],
            'avatar' => $avatarPath,
        ]);

        return redirect()->route('dashboard.sotk.index')
            ->with('success', 'Anggota pengurus ' . $user->name . ' berhasil ditambahkan!')
            ->with('temp_password', $temporaryPassword)
            ->with('temp_email', $user->email);
    }

    public function sotkDestroy(string $id)
    {
        $user = User::findOrFail((int) $id);
        
        if ($user->avatar && Storage::exists($user->avatar)) {
            Storage::delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('dashboard.sotk.index')
            ->with('success', 'Data anggota ' . $user->name . ' berhasil dihapus.');
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
    public function documentsIndex(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $category = trim((string) $request->query('category', ''));
        $prokerId = $request->query('proker_id');

        $query = Document::with(['programKerja', 'uploader'])->latest();

        if ($search !== '') {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($category !== '') {
            $query->where('category', $category);
        }

        if ($prokerId) {
            $query->where('program_kerja_id', $prokerId);
        }

        $documents = $query->paginate(24);
        $prokers = ProgramKerja::orderBy('name')->get(['id', 'name']);

        return view('pages.dashboard.documents.index', compact('documents', 'prokers', 'search', 'category', 'prokerId'));
    }

    public function documentsStore(Request $request)
    {
        $validated = $request->validate([
            'file' => ['required', 'file', 'max:10240', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,zip,rar'],
            'name' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:50'],
            'program_kerja_id' => ['nullable', 'exists:program_kerjas,id'],
        ], [
            'file.required' => 'File dokumen wajib diunggah.',
            'file.max' => 'Ukuran file maksimal adalah 10MB.',
            'file.mimes' => 'Format file yang didukung: PDF, DOCX, XLSX, PPTX, JPG, PNG, ZIP, RAR.',
            'category.required' => 'Kategori dokumen wajib dipilih.',
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        
        $fileType = match ($extension) {
            'pdf' => 'pdf',
            'doc', 'docx' => 'doc',
            'xls', 'xlsx' => 'xls',
            'ppt', 'pptx' => 'ppt',
            'jpg', 'jpeg', 'png' => 'img',
            'zip', 'rar' => 'zip',
            default => 'other',
        };

        $customName = trim($validated['name'] ?? '');
        if ($customName !== '') {
            $fileName = ($extension && !str_ends_with(strtolower($customName), '.' . $extension))
                ? ($customName . '.' . $extension)
                : $customName;
        } else {
            $fileName = $file->getClientOriginalName();
        }

        $filePath = $file->store('documents');

        Document::create([
            'name' => $fileName,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $file->getSize(),
            'category' => $validated['category'],
            'program_kerja_id' => $validated['program_kerja_id'] ?? null,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('dashboard.documents.index')
            ->with('success', 'Dokumen "' . $fileName . '" berhasil diunggah!');
    }

    public function documentsDownload(string $id)
    {
        $doc = Document::findOrFail((int) $id);
        
        if (!Storage::exists($doc->file_path)) {
            return back()->with('error', 'File dokumen tidak ditemukan di penyimpanan.');
        }

        $extension = pathinfo($doc->file_path, PATHINFO_EXTENSION);
        $downloadName = $doc->name;
        if ($extension && !str_ends_with(strtolower($downloadName), '.' . strtolower($extension))) {
            $downloadName .= '.' . $extension;
        }

        $mimeType = Storage::mimeType($doc->file_path) ?: 'application/octet-stream';
        $headers = [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'attachment; filename="' . addslashes($downloadName) . '"',
        ];

        return Storage::download($doc->file_path, $downloadName, $headers);
    }

    public function documentsDestroy(string $id)
    {
        $doc = Document::findOrFail((int) $id);

        if ($doc->file_path && Storage::exists($doc->file_path)) {
            Storage::delete($doc->file_path);
        }

        $doc->delete();

        return redirect()->route('dashboard.documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    // ─── Pengaturan ──────────────────────────────────
    public function settings()
    {
        return view('pages.dashboard.settings');
    }

    // ─── Storage Streaming Proxy (Fallback) ─────────
    public function storageProxy(Request $request, string $path)
    {
        $cleanPath = ltrim(urldecode($path), '/');

        if (!Storage::exists($cleanPath)) {
            // Also check public disk fallback
            if (Storage::disk('public')->exists($cleanPath)) {
                $mimeType = Storage::disk('public')->mimeType($cleanPath) ?: 'application/octet-stream';
                $fileStream = Storage::disk('public')->readStream($cleanPath);
                return response()->stream(function () use ($fileStream) {
                    fpassthru($fileStream);
                    if (is_resource($fileStream)) {
                        fclose($fileStream);
                    }
                }, 200, [
                    'Content-Type' => $mimeType,
                    'Cache-Control' => 'public, max-age=86400',
                ]);
            }

            abort(404, 'File tidak ditemukan di penyimpanan.');
        }

        $mimeType = Storage::mimeType($cleanPath) ?: 'application/octet-stream';
        $fileStream = Storage::readStream($cleanPath);

        return response()->stream(function () use ($fileStream) {
            fpassthru($fileStream);
            if (is_resource($fileStream)) {
                fclose($fileStream);
            }
        }, 200, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}

