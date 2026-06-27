# 📋 Sistem Generator Proposal Digital HMSE

## 📌 Ringkasan

Sistem proposal ini memungkinkan pengguna untuk:
✅ Membuat proposal kegiatan dengan tiga komponen utama:
   - Latar Belakang
   - Tujuan
   - Identifikasi & Mitigasi Risiko

✅ Memilih tingkat risiko: **Rendah** atau **Tinggi**
   - **Rendah**: Perlu persetujuan dari Ketua Panitia & Sekretaris
   - **Tinggi**: Perlu persetujuan dari SEMUA 5 pihak

✅ Generate PDF otomatis dengan tata letak profesional
✅ Sistem approval berjenjang dengan tanda tangan digital
✅ Tracking status persetujuan pada setiap tahap

---

## 🏗️ Struktur Database

### Table: `proposals`
```
id              - Primary Key
user_id         - Foreign Key ke User (pembuat proposal)
title           - Judul proposal
background      - Latar belakang
objective       - Tujuan kegiatan
risk_level      - Enum: 'low' | 'high'
risk_description- Identifikasi & mitigasi risiko
budget          - Anggaran (decimal)
timeline        - Timeline pelaksanaan
file_path       - Path ke PDF yang dihasilkan
status          - Enum: 'draft', 'submitted', 'approved', 'rejected'
rejection_reason- Alasan jika ditolak
created_at
updated_at
deleted_at      - Soft delete
```

### Table: `proposal_approvals`
```
id              - Primary Key
proposal_id     - Foreign Key ke Proposal
approver_id     - Foreign Key ke User (yang approve)
approver_role   - Enum: 'ketua_panitia', 'sekretaris', 'ketua_hima', 'pembina', 'kaprodi'
status          - Enum: 'pending', 'approved', 'rejected'
signature_data  - Data tand tangan digital
notes           - Catatan approval
approved_at     - Timestamp approval
approval_order  - Urutan approval (1-5)
created_at
updated_at
```

---

## 🚀 Flow Penggunaan

### 1. **Membuat Proposal (User)**
```
POST /proposals
- Isi form dengan detail proposal
- Pilih tingkat risiko
- Status proposal: DRAFT
```

### 2. **Generate PDF (User)**
```
POST /proposals/{proposal}/generate-pdf
- Sistem auto-select template berdasarkan risk_level
- Generate PDF dari Blade template
- Simpan ke storage/app/proposals/generated/
```

### 3. **Submit Proposal (User)**
```
POST /proposals/{proposal}/submit
- Status berubah dari DRAFT → SUBMITTED
- Buat approval records untuk semua required approvers
- Buat placeholder untuk tanda tangan
```

### 4. **Approval Berjenjang**
```
POST /proposals/approval/{approval}/approve
- Approver approve dengan optional signature & notes
- Check apakah approval sudah selesai
- Jika semua approve: status → APPROVED, generate final PDF
```

### 5. **Download Final PDF**
```
GET /proposals/{proposal}/download-pdf
- Download proposal dengan semua tanda tangan
```

---

## 📂 File yang Dibuat

### Models
- ✅ `app/Models/Proposal.php` - Model untuk proposal
- ✅ `app/Models/ProposalApproval.php` - Model untuk approval tracking
- ✅ `app/Models/User.php` - Updated dengan relationship proposals()

### Controllers
- ✅ `app/Http/Controllers/ProposalController.php` - Semua logic

### Services
- ✅ `app/Services/ProposalGeneratorService.php` - PDF generation & helpers

### Policies
- ✅ `app/Policies/ProposalPolicy.php` - Authorization rules

### Migrations
- ✅ `database/migrations/200..._create_proposals_table.php`
- ✅ `database/migrations/200..._create_proposal_approvals_table.php`

### Views
- ✅ `resources/views/proposals/create.blade.php` - Form create proposal
- ✅ `resources/views/documents/proposals/pdf-template-low-risk.blade.php`
- ✅ `resources/views/documents/proposals/pdf-template-high-risk.blade.php`
- ✅ `resources/views/documents/proposals/pdf-template-low-risk-final.blade.php`
- ✅ `resources/views/documents/proposals/pdf-template-high-risk-final.blade.php`

### Routes
- ✅ Routes di `routes/web.php` dengan prefix `/proposals`

---

## 🔗 API Endpoints

### Proposal Management
```
GET    /proposals                    - List semua proposal user
POST   /proposals                    - Create proposal baru
GET    /proposals/{proposal}         - Detail proposal
PUT    /proposals/{proposal}         - Update proposal (draft only)
DELETE /proposals/{proposal}         - Delete proposal (draft only)
GET    /proposals/{proposal}/edit    - Form edit proposal
```

### PDF & Submission
```
POST   /proposals/{proposal}/generate-pdf   - Generate PDF
GET    /proposals/{proposal}/download-pdf   - Download PDF
POST   /proposals/{proposal}/submit         - Submit untuk approval
```

### Approval
```
POST   /proposals/approval/{approval}/approve  - Approve proposal
POST   /proposals/approval/{approval}/reject   - Reject proposal
```

---

## 💡 Cara Menggunakan

### Step 1: Akses Form Create
```
http://localhost:8888/proposals/create
```

### Step 2: Isi Form
- Judul proposal
- Pilih risiko: Rendah atau Tinggi
- Isi latar belakang, tujuan, risiko & mitigasi
- Tentukan anggaran dan timeline

### Step 3: Simpan Proposal
- Proposal tersimpan dalam status **DRAFT**
- User bisa edit atau hapus di status ini

### Step 4: Generate & Submit PDF
```
POST /proposals/{proposal}/submit
```
- Proposal diubah ke status **SUBMITTED**
- PDF dihasilkan dan disimpan
- Approval records dibuat untuk setiap approver

### Step 5: Persetujuan Berjenjang
- Setiap approver login dan approve di sistemnya
- Optional: tambah tanda tangan digital dan catatan
- Otomatis move ke approver berikutnya

### Step 6: Final Approval
- Setelah semua approve → Status **APPROVED**
- Final PDF dengan semua signature di-generate
- User bisa download final PDF

---

## 🎨 PDF Templates

### Template Low Risk (`pdf-template-low-risk.blade.php`)
- Warna accent: Hijau (#10B981)
- Header: Biru (#2C3DA6)
- 5 signature blocks siap dicetak manual

### Template High Risk (`pdf-template-high-risk.blade.php`)
- Warna accent: Merah (#EF4444)
- Warning box: "Perhatian - Risiko Tinggi"
- Emphasis pada "Identifikasi & Mitigasi Risiko"
- Sama 5 signature blocks

### Template Final (Low & High Risk)
- Menampilkan signature data dari approvers
- Green badge untuk yang sudah approve
- Timestamp approval tertera
- Professional layout untuk dokumen final

---

## ⚙️ Konfigurasi

### Approval Hierarchy (Urutan Approval)
```php
1. Ketua Panitia
2. Sekretaris
3. Ketua HMSE
4. Pembina HMSE
5. Kaprodi RPL
```

Ubah di: `app/Services/ProposalGeneratorService.php` → `getRequiredApprovers()`

### Risk-based Approvers
Saat ini: **Semua risiko** memerlukan 5 approver

Untuk customize, edit logic di:
- `app/Http/Controllers/ProposalController.php` → method `store()`
- `app/Services/ProposalGeneratorService.php` → method `getRequiredApprovers()`

---

## 📝 Contoh Workflow

**Scenario: Proposal Gathering HMSE (Risiko Tinggi)**

```
1. Panitia Gathering buat proposal di /proposals/create
   ↓
2. Isi semua form field → Pilih "Risiko Tinggi"
   ↓
3. Submit proposal → Status: SUBMITTED
   ↓
4. PDF ter-generate otomatis
   ↓
5. Approval sequence:
   → Ketua Panitia approve (signature 60px canvas)
   → Sekretaris approve
   → Ketua HMSE approve
   → Pembina approve
   → Kaprodi approve
   ↓
6. Setelah semua approve → Status: APPROVED
   ↓
7. Final PDF di-generate dengan semua tanda tangan
   ↓
8. User download PDF final untuk arsip
```

---

## 🔐 Authorization

- ✅ User hanya bisa lihat proposal mereka sendiri
- ✅ Hanya creator yang bisa edit/hapus draft proposal
- ✅ Approvers bisa lihat proposal yang di-assign ke mereka
- ✅ Policy: `app/Policies/ProposalPolicy.php`

---

## 📦 Dependencies

- ✅ `barryvdh/laravel-dompdf` - untuk PDF generation
- ✅ Laravel 12 (built-in)
- ✅ Blade templating

---

## ✨ Next Steps (Optional Enhancement)

1. **Digital Signature Frontend**
   - Tambah canvas element untuk user draw signature
   - Simpan signature data sebagai image/base64

2. **Email Notifications**
   - Email ke approver ketika proposal siap di-approve
   - Reminder jika approval delayed

3. **Dashboard Analytics**
   - Count proposal by status
   - Approval timeline tracking
   - Rejection reason analytics

4. **Bulk Actions**
   - Export multiple proposals
   - Bulk approval untuk admin

5. **Role-based Dashboard**
   - Dashboard untuk creator: ringkasan proposal mereka
   - Dashboard untuk approver: daftar proposal yang pending approval
   - Dashboard untuk admin: semua proposal

---

## 🎯 Testing

Untuk test sistem, cukup:

```bash
# Akses form
http://localhost:8888/proposals/create

# Buat proposal (pastikan sudah login)
- Fill form
- Submit

# Generate PDF
POST /proposals/{proposal}/generate-pdf

# Download PDF
GET /proposals/{proposal}/download-pdf
```

---

## 📞 Support

Untuk pertanyaan atau debugging, check:
- Log file: `storage/logs/laravel.log`
- Database: Inspect `proposals` & `proposal_approvals` tables
- PDF path: `storage/app/proposals/generated/`

---

**Happy Proposal Creating! 🚀**
