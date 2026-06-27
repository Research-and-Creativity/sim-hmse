# ⚡ QUICK START - Generate Proposal dari Template

## 🎯 Goal: Buat proposal yang otomatis terisi dan tetap sesuai template Anda

---

## 📋 Persiapan (One-Time Setup)

### 1. Edit Template Anda
```
1. Buka file: storage/app/templates/proposals/RESIKO TINGGI.docx
2. Edit isi template sesuai keinginan
3. Add placeholder seperti: {{nama_kegiatan}}, {{anggaran}}, dll
   (Lihat PLACEHOLDER_REFERENCE.md untuk daftar lengkap)
4. Save file (Ctrl+S)
5. Upload ke server jika perlu
```

### 2. Cek List
- [x] Template files ada di folder: `storage/app/templates/proposals/`
- [x] File: `RESIKO TINGGI.docx` ✅
- [x] File: `RESIKO SEDANG_RENDAH.docx` ✅
- [x] Placeholder sudah ditambahkan ke template
- [x] PHPWord library sudah installed ✅

---

## 🚀 Cara Menggunakan (User Flow)

### Step 1: Buat Proposal
```
Dashboard → "Buat Proposal" 
   ↓
Isi form proposal:
  • Nama Kegiatan: Workshop UI/UX 2026
  • Latar Belakang: [isi txt]
  • Tujuan: [isi txt]
  • Tingkat Risiko: Pilih "Rendah" atau "Tinggi" ← PENTING
  • Anggaran: 3000000
  • Timeline: [isi txt]
  • Risk Description: [isi txt]
   ↓
Klik "Simpan" atau "Lanjut"
```

### Step 2: Download Dokumen Terisi
```
Buka detail proposal yang sudah dibuat
   ↓
Tab "Info Proposal"
   ↓
Klik tombol: "📥 Download Template Isi"
   ↓
File .docx di-download (proposal_[ID]_[TANGGAL].docx)
```

### Step 3: Buka & Edit Dokumen
```
1. Download file sudah terisi dengan data proposal
2. Open di Microsoft Word
3. File sudah sesuai dengan template original (formatting tetap)
4. Anda bisa edit lebih lanjut jika perlu
5. Save & Print sesuai kebutuhan
```

---

## 📊 Contoh Dari Awal hingga Akhir

### FORM INPUT (User isi di dashboard):
```
Nama Kegiatan:      Workshop UI/UX Design 2026
Latar Belakang:     Kegiatan ini bertujuan untuk memberikan 
                    pelatihan desain kepada mahasiswa
Tujuan Kegiatan:    Meningkatkan kemampuan mahasiswa dalam 
                    membuat interface yang baik
Tingkat Risiko:     Rendah
Anggaran:           3200000
Timeline:           15 April - 30 April 2026
Risk Description:   Risiko minimal karena peserta terbatas
```

### TEMPLATE CONTENT (Di RESIKO SEDANG_RENDAH.docx):
```
═══════════════════════════════════════
        PROPOSAL KEGIATAN HMSE
═══════════════════════════════════════

IDENTITAS
─────────
Kegiatan: {{nama_kegiatan}}
Tanggal: {{tanggal_dibuat}}
Tingkat Risiko: {{tingkat_risiko}}

DESKRIPSI
─────────
{{latar_belakang}}

TUJUAN
──────
{{tujuan}}

ANGGARAN: {{anggaran}}

CATATAN RISIKO:
{{deskripsi_risiko}}

JADWAL:
{{timeline}}
```

### HASIL DOWNLOAD (File yang user terima):
```
═══════════════════════════════════════
        PROPOSAL KEGIATAN HMSE
═══════════════════════════════════════

IDENTITAS
─────────
Kegiatan: Workshop UI/UX Design 2026
Tanggal: 10/04/2026
Tingkat Risiko: Rendah

DESKRIPSI
─────────
Kegiatan ini bertujuan untuk memberikan pelatihan desain 
kepada mahasiswa

TUJUAN
──────
Meningkatkan kemampuan mahasiswa dalam membuat interface 
yang baik

ANGGARAN: Rp 3.200.000

CATATAN RISIKO:
Risiko minimal karena peserta terbatas

JADWAL:
15 April - 30 April 2026
```

---

## ✨ Available Placeholders

Gunakan placeholder berikut di template:

```
{{nama_kegiatan}}       → Nama kegiatan
{{latar_belakang}}      → Latar belakang
{{tujuan}}              → Tujuan kegiatan  
{{anggaran}}            → Anggaran (Rp X.XXX.XXX)
{{timeline}}            → Timeline kegiatan
{{tingkat_risiko}}      → Tingkat risiko
{{deskripsi_risiko}}    → Deskripsi risiko
{{tanggal_dibuat}}      → Tanggal dibuat
{{nama_pembuat}}        → Nama pembuat
```

**Lihat PLACEHOLDER_REFERENCE.md untuk detail lengkap**

---

## 🎨 Cara Menambah/Edit Placeholder di Template

### Buka Template di Word

1. Buka: `storage/app/templates/proposals/RESIKO TINGGI.docx`
2. Edit konten sesuai kebutuhan
3. Di tempat yang ingin otomatis terisi, ketik placeholder:

```docx
SEBELUM (hardcoded):
──────────────────
Kegiatan ini bernama: Workshop UI/UX Design 2026


SESUDAH (dengan placeholder):
─────────────────────────────
Kegiatan ini bernama: {{nama_kegiatan}}
```

4. Save file (Ctrl+S)
5. Done! Template siap pakai

### CATATAN:
- Placeholder bisa di mana saja dalam dokumen
- Format tetap sesuai template original
- Multiple placeholder dalam satu dokumen didukung
- Placeholder case-insensitive (bisa uppercase atau lowercase)

---

## 🔄 Workflow Lengkap

```
┌──────────────────────────────────────────┐
│ 1. Edit Template (SETUP)                 │
│    Add placeholder seperti:              │
│    {{nama_kegiatan}}, {{anggaran}}, dll  │
└────────────────┬─────────────────────────┘
                 ↓
┌──────────────────────────────────────────┐
│ 2. User Buat Proposal (FORM)             │
│    Isi semua field di dashboard          │
│    - Nama, Tujuan, Anggaran, Risiko, dll │
└────────────────┬─────────────────────────┘
                 ↓
┌──────────────────────────────────────────┐
│ 3. User Click "Download Template Isi"    │
└────────────────┬─────────────────────────┘
                 ↓
┌──────────────────────────────────────────┐
│ 4. System Process:                       │
│    a. Baca template DOCX                 │
│    b. Cari placeholder ({{...}})         │
│    c. Replace dengan data proposal       │
│    d. Buat file DOCX baru                │
│    e. Send untuk download                │
└────────────────┬─────────────────────────┘
                 ↓
┌──────────────────────────────────────────┐
│ 5. User Download & Use                   │
│    File: proposal_[ID]_[DATE].docx       │
│    Open di Word, edit, print, submit     │
└──────────────────────────────────────────┘
```

---

## 🎯 Tips Sukses

### ✅ DO's
```
✅ Gunakan placeholder yang benar: {{nama_kegiatan}}
✅ Isi form proposal dengan data lengkap
✅ Pilih tingkat risiko yang sesuai
✅ Save template sebelum upload
✅ Test dengan membuat proposal sample
✅ Backup template sebelum edit
```

### ❌ DON'Ts
```
❌ Jangan pakai space extra: {{ nama_kegiatan }}
❌ Jangan typo di placeholder: {{nama_kegiatann}}
❌ Jangan kosongkan form proposal
❌ Jangan lupa pilih tingkat risiko
❌ Jangan edit langsung di server tanpa backup
```

---

## 🧪 Test Template Anda

### Quick Test:

```
1. Edit template → add placeholder
2. Create proposal → isi semua field
3. Click Download → check hasilnya
4. If OK → deploy & share dengan pengguna
5. If ERROR → check placeholder names & form data
```

### Debugging:

```
Problem: Template tidak ada
→ Check folder: storage/app/templates/proposals/

Problem: Placeholder tidak terisi
→ Check placeholder name spelling
→ Check form data tidak kosong
→ Check error log: storage/logs/laravel.log

Problem: Format rusak
→ Template DOCX might be corrupted
→ Re-upload template file
```

---

## 📱 User Interface

### Sebelum (Old):
```
Dashboard → Proposal List → Show
   → Download PDF
   → Preview
```

### Sesudah (WITH TEMPLATE):
```
Dashboard → Proposal List → Show → Info Tab
   → Preview Dokumen (old PDF)
   → Download Template Isi ← NEW BUTTON
   → Download PDF (old)
```

---

## ⚙️ Technical Stack

- **Language:** PHP 8.2+
- **Framework:** Laravel 12
- **Library:** PHPWord 1.4.0 (untuk manipulasi DOCX)
- **Database:** Proposal & ProposalApproval tables
- **Storage:** `storage/app/templates/proposals/` (private)

---

## 📚 File References

| File | Purpose |
|------|---------|
| `app/Services/ProposalTemplateFillerService.php` | Logic untuk fill template |
| `app/Http/Controllers/ProposalController.php` | Handle download request |
| `routes/web.php` | Routes untuk generate-filled |
| `resources/views/proposals/preview-filled.blade.php` | Preview page |
| `storage/app/templates/proposals/` | Template storage |

---

## 🚀 Already Setup?

- [x] PHPWord library installed ✅
- [x] ProposalTemplateFillerService created ✅
- [x] Routes configured ✅
- [x] UI buttons added ✅
- [x] Documentation complete ✅

**Everything is ready to use!**

---

## 📞 Need Help?

**Lihat dokumentasi lengkap:**
1. `TEMPLATE_USAGE_GUIDE.md` - Full guide dengan contoh detail
2. `PLACEHOLDER_REFERENCE.md` - Reference lengkap placeholder
3. `PROPOSAL_SYSTEM_README.md` - Dokumentasi sistem proposal
4. `TEMPLATE_IMPLEMENTATION_COMPLETE.md` - Technical summary

---

**Status:** ✅ READY TO USE  
**Last Updated:** April 10, 2026  
**System:** SIM HMSE v1.0
