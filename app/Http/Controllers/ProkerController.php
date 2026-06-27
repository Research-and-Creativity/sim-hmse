<?php

namespace App\Http\Controllers;

use App\Models\ProgramKerja;
use Illuminate\Http\Request;

class ProkerController extends Controller
{
    public function index(Request $request)
    {
        $accounts = collect($this->dummyAccounts())->keyBy('id');
        $statusLabels = $this->prokerStatusOptions();
        $statusOptions = $statusLabels;

        $divisionOptions = collect($this->defaultDivisionOptions())
            ->mapWithKeys(fn (string $division) => [trim($division) => trim($division)])
            ->all();

        $filters = [
            'search' => trim((string) $request->query('search', '')),
            'status' => trim((string) $request->query('status', '')),
            'divisi' => trim((string) $request->query('divisi', '')),
        ];

        $query = ProgramKerja::query()
            ->when($filters['search'] !== '', function ($q) use ($filters, $accounts, $statusLabels) {
                $search = mb_strtolower($filters['search']);

                $matchedAccountIds = $accounts
                    ->filter(function (array $account) use ($search) {
                        $haystack = mb_strtolower(implode(' ', [
                            $account['name'] ?? '',
                            $account['email'] ?? '',
                            $account['role'] ?? '',
                            $account['division'] ?? '',
                        ]));

                        return str_contains($haystack, $search);
                    })
                    ->keys()
                    ->values()
                    ->all();

                $matchedStatuses = collect($statusLabels)
                    ->filter(function (string $label, string $value) use ($search) {
                        return str_contains(mb_strtolower($value . ' ' . $label), $search);
                    })
                    ->keys()
                    ->values()
                    ->all();

                $q->where(function ($innerQuery) use ($search, $matchedAccountIds, $matchedStatuses) {
                    $innerQuery
                        ->where('name', 'like', '%' . $search . '%')
                        ->orWhere('division', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('location', 'like', '%' . $search . '%')
                        ->orWhere('risk_level', 'like', '%' . $search . '%')
                        ->orWhereIn('pj_user_id', $matchedAccountIds)
                        ->orWhereIn('status', $matchedStatuses);
                });
            })
            ->when($filters['status'] !== '', function ($q) use ($filters) {
                $status = mb_strtolower($filters['status']);

                $q->whereRaw('LOWER(TRIM(status)) = ?', [$status]);
            })
            ->when($filters['divisi'] !== '', function ($q) use ($filters) {
                $division = mb_strtolower($filters['divisi']);

                $q->whereRaw('LOWER(TRIM(division)) = ?', [$division]);
            })
            ->latest();

        $prokers = $query
            ->get()
            ->filter(function (ProgramKerja $proker) use ($filters, $accounts, $statusLabels) {
                if ($filters['status'] !== '' && mb_strtolower(trim((string) $proker->status)) !== mb_strtolower($filters['status'])) {
                    return false;
                }

                if ($filters['divisi'] !== '' && mb_strtolower(trim((string) $proker->division)) !== mb_strtolower($filters['divisi'])) {
                    return false;
                }

                if ($filters['search'] === '') {
                    return true;
                }

                $search = mb_strtolower($filters['search']);

                $pj = $accounts->get($proker->pj_user_id);
                $pjHaystack = mb_strtolower(implode(' ', [
                    $pj['name'] ?? '',
                    $pj['email'] ?? '',
                    $pj['role'] ?? '',
                    $pj['division'] ?? '',
                ]));

                $statusHaystack = mb_strtolower(implode(' ', [
                    $proker->status ?? '',
                    $statusLabels[$proker->status] ?? '',
                ]));

                $prokerHaystack = mb_strtolower(implode(' ', [
                    $proker->name ?? '',
                    $proker->division ?? '',
                    $proker->description ?? '',
                    $proker->location ?? '',
                    $proker->risk_level ?? '',
                ]));

                return str_contains($prokerHaystack, $search)
                    || str_contains($pjHaystack, $search)
                    || str_contains($statusHaystack, $search);
            })
            ->map(function (ProgramKerja $proker) use ($accounts): array {
                $pj = $accounts->get($proker->pj_user_id);

                return [
                    'id' => $proker->id,
                    'name' => $proker->name,
                    'divisi' => $proker->division,
                    'status' => $proker->status,
                    'date_start' => optional($proker->date_start)->format('d M Y') ?: '-',
                    'date_end' => optional($proker->date_end)->format('d M Y') ?: '-',
                    'pj' => $pj['name'] ?? 'User Tidak Ditemukan',
                    'progress' => $this->prokerProgressFromStatus($proker->status),
                    'color' => $proker->color ?: '#2C3DA6',
                ];
            })
            ->values();

        return view('pages.dashboard.proker.index', compact('prokers', 'filters', 'statusOptions', 'divisionOptions'));
    }

    public function create()
    {
        $accounts = collect($this->dummyAccounts());

        $divisionOptions = collect($this->defaultDivisionOptions());

        return view('pages.dashboard.proker.create', compact('accounts', 'divisionOptions'));
    }

    public function store(Request $request)
    {
        $allowedAccountIds = collect($this->dummyAccounts())->pluck('id')->all();
        $today = now()->format('Y-m-d');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'division' => ['required', 'string', 'max:150'],
            'pj_user_id' => ['required', 'integer', 'in:' . implode(',', $allowedAccountIds)],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'target_participants' => ['nullable', 'integer', 'min:1'],
            'risk_level' => ['required', 'in:rendah,sedang,tinggi'],
            'date_start' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:' . $today],
            'date_end' => ['required', 'date', 'after_or_equal:date_start'],
            'timeline_titles' => ['array'],
            'timeline_titles.*' => ['nullable', 'string', 'max:255'],
            'timeline_dates' => ['array'],
            'timeline_dates.*' => ['nullable', 'date'],
            'budget_item_names' => ['array'],
            'budget_item_names.*' => ['nullable', 'string', 'max:255'],
            'budget_qtys' => ['array'],
            'budget_qtys.*' => ['nullable', 'string', 'max:100'],
            'budget_units' => ['array'],
            'budget_units.*' => ['nullable', 'string', 'max:100'],
            'budget_prices' => ['array'],
            'budget_prices.*' => ['nullable', 'numeric', 'min:0'],
        ]);

        $timelines = $this->buildTimeline($request->input('timeline_titles', []), $request->input('timeline_dates', []));
        $budgetItems = $this->buildBudgetItems($request->input('budget_item_names', []), $request->input('budget_qtys', []), $request->input('budget_units', []), $request->input('budget_prices', []));

        $proker = ProgramKerja::create([
            'name' => $validated['name'],
            'division' => $validated['division'],
            'status' => 'draft',
            'pj_user_id' => $validated['pj_user_id'],
            'date_start' => $validated['date_start'],
            'date_end' => $validated['date_end'],
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'] ?? null,
            'target_participants' => $validated['target_participants'] ?? null,
            'risk_level' => $validated['risk_level'],
            'progress' => 0,
            'color' => $this->prokerDivisionColor($validated['division']),
            'timeline' => $timelines,
            'documents' => [],
            'budget_items' => $budgetItems,
            'committee_member_ids' => [$validated['pj_user_id']],
        ]);

        return redirect()
            ->route('dashboard.proker.show', $proker->id)
            ->with('success', 'Program kerja berhasil disimpan.');
    }

    public function edit(string $id)
    {
        $accounts = collect($this->dummyAccounts());
        $proker = ProgramKerja::query()->findOrFail((int) $id);

        $divisionOptions = collect($this->defaultDivisionOptions());

        $formState = [
            'id' => $proker->id,
            'name' => $proker->name,
            'division' => $proker->division,
            'pj_user_id' => (string) $proker->pj_user_id,
            'description' => $proker->description,
            'location' => $proker->location,
            'target_participants' => $proker->target_participants,
            'date_start' => optional($proker->date_start)->format('Y-m-d'),
            'date_end' => optional($proker->date_end)->format('Y-m-d'),
            'risk_level' => $proker->risk_level ?? 'rendah',
            'timeline' => $proker->timeline ?? [],
            'budget_items' => $proker->budget_items ?? [],
            'status' => $proker->status,
        ];

        return view('pages.dashboard.proker.edit', compact('accounts', 'divisionOptions', 'formState'));
    }

    public function update(Request $request, string $id)
    {
        $allowedAccountIds = collect($this->dummyAccounts())->pluck('id')->all();
        $proker = ProgramKerja::query()->findOrFail((int) $id);
        $today = now()->format('Y-m-d');

        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'division'              => ['required', 'string', 'max:150'],
            'pj_user_id'            => ['required', 'integer', 'in:' . implode(',', $allowedAccountIds)],
            'description'           => ['nullable', 'string'],
            'location'              => ['nullable', 'string', 'max:255'],
            'target_participants'   => ['nullable', 'integer', 'min:1'],
            'risk_level'            => ['required', 'in:rendah,sedang,tinggi'],
            'date_start'            => ['required', 'date'],
            'date_end'              => ['required', 'date', 'after_or_equal:date_start'],
            'status'                => ['required', 'in:draft,preparation,on-progress,completed,cancelled'],
            'timeline_titles'       => ['array'],
            'timeline_titles.*'     => ['nullable', 'string', 'max:255'],
            'timeline_dates'        => ['array'],
            'timeline_dates.*'      => ['nullable', 'date'],
            'budget_item_names'     => ['array'],
            'budget_item_names.*'   => ['nullable', 'string', 'max:255'],
            'budget_qtys'           => ['array'],
            'budget_qtys.*'         => ['nullable', 'string', 'max:100'],
            'budget_units'          => ['array'],
            'budget_units.*'        => ['nullable', 'string', 'max:100'],
            'budget_prices'         => ['array'],
            'budget_prices.*'       => ['nullable', 'numeric', 'min:0'],
            // Public event fields
            'poster'                => ['nullable', 'image', 'max:2048'],
            'is_public'             => ['nullable', 'boolean'],
            'open_registration'     => ['nullable', 'boolean'],
            'registration_deadline' => ['nullable', 'date'],
            'registration_quota'    => ['nullable', 'integer', 'min:1'],
        ]);

        $timelines   = $this->buildTimeline($request->input('timeline_titles', []), $request->input('timeline_dates', []), true);
        $budgetItems = $this->buildBudgetItems($request->input('budget_item_names', []), $request->input('budget_qtys', []), $request->input('budget_units', []), $request->input('budget_prices', []));

        // Handle poster upload
        $posterPath = $proker->poster;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        $proker->update([
            'name'                  => $validated['name'],
            'division'              => $validated['division'],
            'status'                => $validated['status'],
            'pj_user_id'            => $validated['pj_user_id'],
            'date_start'            => $validated['date_start'],
            'date_end'              => $validated['date_end'],
            'description'           => $validated['description'] ?? null,
            'location'              => $validated['location'] ?? null,
            'target_participants'   => $validated['target_participants'] ?? null,
            'risk_level'            => $validated['risk_level'],
            'progress'              => $this->prokerProgressFromStatus($validated['status']),
            'color'                 => $this->prokerDivisionColor($validated['division']),
            'timeline'              => $timelines,
            'budget_items'          => $budgetItems,
            'committee_member_ids'  => [$validated['pj_user_id']],
            // Public event fields
            'poster'                => $posterPath,
            'is_public'             => (bool) $request->input('is_public', false),
            'open_registration'     => (bool) $request->input('open_registration', false),
            'registration_deadline' => $validated['registration_deadline'] ?? null,
            'registration_quota'    => $validated['registration_quota'] ?? null,
        ]);

        return redirect()
            ->route('dashboard.proker.show', $proker->id)
            ->with('success', 'Program kerja berhasil diperbarui.');
    }


    public function show(string $id)
    {
        $accounts = collect($this->dummyAccounts())->keyBy('id');
        $prokerRow = ProgramKerja::query()->findOrFail((int) $id);

        $pj = $accounts->get($prokerRow->pj_user_id);

        $committeeMembers = collect($prokerRow->committee_member_ids ?? [])
            ->map(fn (int $memberId) => $accounts->get($memberId))
            ->filter()
            ->values();

        if ($committeeMembers->isEmpty() && $pj) {
            $committeeMembers = collect([$pj]);
        }

        $timelineSteps = collect($prokerRow->timeline ?? [])
            ->map(function (array $step): array {
                return [
                    'title' => $step['title'] ?? 'Tahapan',
                    'date' => !empty($step['date']) ? date('d M Y', strtotime($step['date'])) : '-',
                    'description' => $step['description'] ?? 'Tahapan kegiatan.',
                    'done' => (bool) ($step['done'] ?? false),
                    'active' => (bool) ($step['active'] ?? false),
                ];
            })
            ->values();

        $doneSteps = $timelineSteps
            ->filter(fn (array $step) => ($step['done'] ?? false) || ($step['active'] ?? false))
            ->count();
        $totalSteps = $timelineSteps->count();

        $proposal = \App\Models\Proposal::where('proker_id', $prokerRow->name)->first();
        $riskLevelLabel = $this->prokerRiskLevelLabel($prokerRow->risk_level ?? 'rendah');

        $proker = [
            'id' => $prokerRow->id,
            'name' => $prokerRow->name,
            'divisi' => $prokerRow->division,
            'status' => $prokerRow->status,
            'date_start' => $prokerRow->date_start?->format('d M Y') ?? '-',
            'date_end' => $prokerRow->date_end?->format('d M Y') ?? '-',
            'location' => $prokerRow->location ?: '-',
            'target_participants' => (int) ($prokerRow->target_participants ?? 0),
            'risk_level' => $riskLevelLabel,
            'description' => $prokerRow->description ?: '-',
            'timeline' => $timelineSteps->all(),
            'documents' => $prokerRow->documents ?? [],
            'budget_items' => $prokerRow->budget_items ?? [],
            'progress' => $this->prokerProgressFromStatus($prokerRow->status),
        ];

        return view('pages.dashboard.proker.show', [
            'proker' => $proker,
            'pj' => $pj,
            'committeeMembers' => $committeeMembers,
            'doneSteps' => $doneSteps,
            'totalSteps' => $totalSteps,
            'lastUpdated' => $prokerRow->updated_at?->format('d M Y, H:i') ?? now()->format('d M Y, H:i'),
            'proposal' => $proposal,
        ]);
    }

    private function buildTimeline(array $titles, array $dates, bool $includeDoneFlag = false): array
    {
        return collect($titles)
            ->map(function ($title, $index) use ($dates, $includeDoneFlag) {
                $title = trim((string) $title);
                $date = $dates[$index] ?? null;

                if ($title === '' && blank($date)) {
                    return null;
                }

                $item = [
                    'title' => $title !== '' ? $title : 'Tahapan ' . ($index + 1),
                    'date' => $date,
                    'description' => null,
                ];

                if ($includeDoneFlag) {
                    $item['done'] = false;
                }

                return $item;
            })
            ->filter()
            ->values()
            ->all();
    }

    private function buildBudgetItems(array $names, array $qtys, array $units, array $prices): array
    {
        return collect($names)
            ->map(function ($name, $index) use ($qtys, $units, $prices) {
                $name = trim((string) $name);
                $qty = trim((string) ($qtys[$index] ?? ''));
                $unit = trim((string) ($units[$index] ?? ''));
                $price = (float) ($prices[$index] ?? 0);

                if ($name === '' && $qty <= 0 && $price <= 0) {
                    return null;
                }

                return [
                    'item' => $name !== '' ? $name : 'Item ' . ($index + 1),
                    'qty' => $qty !== '' ? $qty : '-',
                    'unit' => $unit !== '' ? $unit : '-',
                    'price' => (int) round($price),
                ];
            })
            ->filter()
            ->values()
            ->all();
    }

    private function dummyAccounts(): array
    {
        return [
            ['id' => 1, 'name' => 'Ahmad Fauzi', 'email' => 'ahmad.fauzi@hmse.local', 'role' => 'Ketua Panitia', 'division' => 'Research and Creativity'],
            ['id' => 2, 'name' => 'Siti Nurhaliza', 'email' => 'siti.nurhaliza@hmse.local', 'role' => 'Sekretaris', 'division' => 'Internal and External Communication'],
            ['id' => 3, 'name' => 'Budi Hartono', 'email' => 'budi.hartono@hmse.local', 'role' => 'Bendahara', 'division' => 'Resource Management'],
            ['id' => 4, 'name' => 'Diana Putri', 'email' => 'diana.putri@hmse.local', 'role' => 'Sie Acara', 'division' => 'Economy Creative'],
            ['id' => 5, 'name' => 'Rizky Pratama', 'email' => 'rizky.pratama@hmse.local', 'role' => 'Sie Pubdekdok', 'division' => 'Creative Media and Information'],
            ['id' => 6, 'name' => 'Rony Setiawan', 'email' => 'rony.setiawan@hmse.local', 'role' => 'Sie Konsumsi', 'division' => 'Research and Creativity'],
        ];
    }

    private function prokerStatusOptions(): array
    {
        return [
            'draft' => 'Draft',
            'preparation' => 'Persiapan',
            'on-progress' => 'On Progress',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
    }

    private function defaultDivisionOptions(): array
    {
        return [
            'Resource Management',
            'Internal and External Communication',
            'Research and Creativity',
            'Economy Creative',
            'Creative Media and Information',
        ];
    }

    private function prokerDivisionColor(string $division): string
    {
        return match ($division) {
            'Divisi Akademik' => '#2C3DA6',
            'Divisi Kreatif' => '#ec4899',
            'Divisi Eksternal' => '#00C4D8',
            'Divisi Kewirausahaan' => '#f59e0b',
            'Divisi Olahraga & Seni' => '#6b7280',
            default => '#2C3DA6',
        };
    }

    private function prokerProgressFromStatus(string $status): int
    {
        return match ($status) {
            'draft' => 0,
            'preparation' => 40,
            'on-progress' => 80,
            'completed' => 100,
            'cancelled' => 0,
            default => 0,
        };
    }

    private function prokerRiskLevelLabel(string $riskLevel): string
    {
        return match ($riskLevel) {
            'rendah' => 'Resiko Rendah',
            'sedang' => 'Resiko Sedang',
            'tinggi' => 'Resiko Tinggi',
            default => 'Resiko Rendah',
        };
    }
}
