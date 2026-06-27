# 📄 How to Create Proposals Using Your Templates

## Overview

Sistem ini memungkinkan Anda untuk:
1. **Mendownload proposal yang sudah terisi** dari template asli Anda
2. **Menggunakan template Anda sebagai basis** - Data proposal akan mengisi template secara otomatis
3. **Hasilnya tetap mempertahankan desain template** - Format, warna, layout semuanya sesuai template asli

---

## 🎯 Cara Menggunakan

### Step 1: Create Proposal (Form)
1. Buka Dashboard → Buat Proposal
2. Isi semua field form:
   - Nama Kegiatan
   - Latar Belakang
   - Tujuan Kegiatan
   - Tingkat Risiko (Rendah/Tinggi) ← **PENTING!**
   - Anggaran
   - Timeline
   - Deskripsi Risiko

### Step 2: Lihat Detail Proposal
1. Klik "Lihat" pada proposal yang sudah dibuat
2. Di tab "Info Proposal" Anda akan lihat tombol baru: **"Download Template Isi"**
3. Klik tombol tersebut untuk download dokumen Word yang sudah terisi

### Step 3: Download Document
- File akan di-download sebagai `proposal_[ID]_[TANGGAL].docx`
- Dokumen sudah terisi dengan data dari form Anda
- Format tetap sesuai template asli

---

## 📋 Struktur Template DOCX

Template Anda di folder `storage/app/templates/proposals/`:
- **RESIKO SEDANG_RENDAH.docx** - Untuk proposal risiko rendah
- **RESIKO TINGGI.docx** - Untuk proposal risiko tinggi

### Menggunakan Placeholder

Anda dapat menempatkan placeholder di template untuk data yang akan diisi otomatis:

```
{{nama_kegiatan}}       → Nama kegiatan dari form
{{latar_belakang}}      → Latar belakang kegiatan
{{tujuan}}              → Tujuan kegiatan
{{anggaran}}            → Anggaran (format: Rp X.XXX.XXX)
{{timeline}}            → Timeline kegiatan
{{tingkat_risiko}}      → Tingkat risiko (Rendah/Tinggi)
{{deskripsi_risiko}}    → Deskripsi risiko
{{tanggal_dibuat}}      → Tanggal dibuat (dd/mm/yyyy)
{{nama_pembuat}}        → Nama pembuat proposal (dari user)
```

**Contoh di template:**
```
PROPOSAL: {{nama_kegiatan}}
Tanggal Dibuat: {{tanggal_dibuat}}
Anggaran: {{anggaran}}
Tingkat Risiko: {{tingkat_risiko}}

Latar Belakang:
{{latar_belakang}}

Tujuan:
{{tujuan}}
```

**Hasilnya akan menjadi:**
```
PROPOSAL: Workshop UI/UX Design 2026
Tanggal Dibuat: 10/04/2026
Anggaran: Rp 3.200.000
Tingkat Risiko: Rendah

Latar Belakang:
Kegiatan ini bertujuan untuk memberikan pelatihan...

Tujuan:
Meningkatkan kemampuan mahasiswa dalam...
```

---

## ⚙️ Workflow Lengkap

```
┌─────────────────────────────────────────────────────────────┐
│ 1. User fills proposal form in dashboard                   │
│    (nama, tujuan, anggaran, tingkat risiko, etc)           │
└────────────────────────┬────────────────────────────────────┘
                         ↓
┌─────────────────────────────────────────────────────────────┐
│ 2. User clicks "Download Template Isi" button              │
│    pada detail proposal                                    │
└────────────────────────┬────────────────────────────────────┘
                         ↓
┌─────────────────────────────────────────────────────────────┐
│ 3. System reads template DOCX from storage folder           │
│    (RESIKO SEDANG_RENDAH.docx atau RESIKO TINGGI.docx)    │
└────────────────────────┬────────────────────────────────────┘
                         ↓
┌─────────────────────────────────────────────────────────────┐
│ 4. System finds and replaces all placeholders:            │
│    {{nama_kegiatan}} → Workshop UI/UX Design 2026         │
│    {{anggaran}} → Rp 3.200.000                            │
│    {{latar_belakang}} → [isi dari form]                   │
│    etc...                                                  │
└────────────────────────┬────────────────────────────────────┘
                         ↓
┌─────────────────────────────────────────────────────────────┐
│ 5. System saves new DOCX file to storage                   │
│    (with all placeholders replaced)                        │
└────────────────────────┬────────────────────────────────────┘
                         ↓
┌─────────────────────────────────────────────────────────────┐
│ 6. File is sent to user for download                       │
│    Format: proposal_[ID]_[TANGGAL].docx                    │
└─────────────────────────────────────────────────────────────┘
```

---

## 🎨 Editing Templates

### Cara Mengedit Template Anda

1. **Buka template di Microsoft Word**
   - Lokasi: `storage/app/templates/proposals/RESIKO TINGGI.docx`
   - Atau: `storage/app/templates/proposals/RESIKO SEDANG_RENDAH.docx`

2. **Tambahkan placeholder** untuk field yang ingin diisi otomatis
   - Contoh: `{{nama_kegiatan}}`, `{{anggaran}}`, dll

3. **Formatter bebas** - Anda bisa:
   - Mengubah font, warna, ukuran
   - Menambah logo, image, header/footer
   - Menambah tabel, chart, dll
   - Style apapun yang Anda inginkan

4. **Save template** ke mana saja
   - Sistem akan tetap membaca file dari folder storage

5. **Upload ke server**
   - Ganti file di `storage/app/templates/proposals/`
   - Hapus file lama, upload file baru
   - Atau edit langsung file yang ada

### Tips Editing:
- ✅ Buka file DOCX dengan Word, LibreOffice, atau aplikasi Office lainnya
- ✅ Placeholder bisa di manapun dalam dokumen
- ✅ Gunakan format `{{variabel}}` or `{variabel}` (keduanya didukung)
- ✅ Save dalam format .DOCX (Word 2007+)
- ✅ File harus dalam folder yang benar

---

## 🔄 Contoh Penggunaan

### Scenario: Membuat Proposal Kegiatan

**User Data:**
```
Nama Kegiatan: Workshop UI/UX Design 2026
Latar Belakang: Kegiatan ini dirancang untuk...
Tujuan: Meningkatkan skill mahasiswa...
Anggaran: 3200000
Tingkat Risiko: low (Rendah)
Timeline: 15 April 2026
```

**Template File Content (Simplified):**
```
═══════════════════════════════════════════
        PROPOSAL KEGIATAN HMSE
═══════════════════════════════════════════

Nama Kegiatan: {{nama_kegiatan}}
Tanggal: {{tanggal_dibuat}}
Tingkat Risiko: {{tingkat_risiko}}

PENDAHULUAN
───────────
{{latar_belakang}}

TUJUAN KEGIATAN
───────────────
{{tujuan}}

ANGGARAN
────────
Total: {{anggaran}}

Disetujui oleh: {{nama_pembuat}}
```

**Generated Document Output:**
```
═══════════════════════════════════════════
        PROPOSAL KEGIATAN HMSE
═══════════════════════════════════════════

Nama Kegiatan: Workshop UI/UX Design 2026
Tanggal: 10/04/2026
Tingkat Risiko: Rendah

PENDAHULUAN
───────────
Kegiatan ini dirancang untuk...

TUJUAN KEGIATAN
───────────────
Meningkatkan skill mahasiswa...

ANGGARAN
────────
Total: Rp 3.200.000

Disetujui oleh: Ahmad Fauzi
```

---

## 🚀 Fitur-Fitur

✅ **Dynamic Template Selection**
- Sistem otomatis memilih template berdasarkan "Tingkat Risiko"
- Rendah → RESIKO SEDANG_RENDAH.docx
- Tinggi → RESIKO TINGGI.docx

✅ **Placeholder Replacement**
- Support multiple placeholder formats: `{{var}}`, `{var}`
- Support uppercase & lowercase
- Aman - hanya placeholder yang dikenal yang diganti

✅ **Format Preservation**
- Design template tetap terjaga
- Styling, warna, font semua same
- Tabel, image tetap utuh

✅ **Error Handling**
- Jika template tidak ditemukan → Error message
- Jika placeholder tidak cocok → Dibiarkan apa adanya
- All safe - tidak ada data loss

✅ **File Management**
- Generated file disimpan di storage
- Filename: `proposal_[ID]_[unique].docx`
- Siap untuk download atau cetak

---

## 🛠️ Setup Checklist

- [x] PHPWord library sudah installed
- [x] ProposalTemplateFillerService sudah dibuat
- [x] Routes sudah ditambahkan
- [x] Controller methods sudah ditambahkan
- [x] UI buttons sudah ditambahkan di proposal view
- [x] Template folder sudah ready
- [x] Cache sudah di-clear
- [x] Dokumentasi lengkap

---

## 📂 File Locations

**Service:**
```
app/Services/ProposalTemplateFillerService.php
```

**Controller Methods:**
```
app/Http/Controllers/ProposalController.php
- generateFilledDocument()
- previewFilledDocument()
```

**Routes:**
```
routes/web.php
- GET /proposals/{proposal}/generate-filled
- GET /proposals/{proposal}/preview-filled
```

**Views:**
```
resources/views/proposals/preview-filled.blade.php
resources/views/pages/dashboard/proposal/show.blade.php (updated)
```

**Templates (Your DOCX files):**
```
storage/app/templates/proposals/
├── RESIKO SEDANG_RENDAH.docx
└── RESIKO TINGGI.docx
```

---

## 💡 Tips & Tricks

### 1. Update Template
```
1. Buka template di Word
2. Edit content/styling
3. Tambah/ubah placeholder
4. Save as DOCX
5. Upload ke folder storage
6. Cache sudah auto-clear saat access
```

### 2. Test Placeholder
```
Buat proposal dengan data sederhana
Download document
Buka di Word
Check apakah placeholder sudah terisi dengan benar
```

### 3. Backup Template
```
Selalu backup template original
Sebelum edit, copy ke safe location
Kalau ada error, restore dari backup
```

### 4. Custom Placeholder
```
Jika butuh placeholder baru:
1. Edit ProposalTemplateFillerService.php
2. Add ke getPlaceholderMappings()
3. Update template DOCX dengan placeholder baru
4. Clear cache
```

---

## ⚠️ Troubleshooting

### Template not found
**Error:** "Template file not found"
**Solution:** 
```
1. Check file exists di storage/app/templates/proposals/
2. Verify filename: RESIKO SEDANG_RENDAH.docx atau RESIKO TINGGI.docx
3. Clear cache: php artisan cache:clear
```

### Placeholder not replaced
**Problem:** {{nama_kegiatan}} tetap muncul di hasil
**Solutions:**
```
1. Kecil-besar huruf harus sama (case-sensitive)
2. Gunakan format yang didukung: {{var}} atau {var}
3. Tidak ada spasi tambahan di dalam placeholder
4. Placeholder harus dalam text editor (bukan di image/header)
```

### File won't open
**Problem:** Downloaded DOCX file tidak bisa dibuka
**Solutions:**
```
1. Download lagi (mungkin corrupted)
2. Check folder storage/app/proposals/ apakah file sudah dibuat
3. Check error log di storage/logs/laravel.log
```

### Styling lost
**Problem:** Format template hilang di hasil
**Solutions:**
```
1. PHPWord preserve formatting - tapi bisa ada bug
2. Edit template - pastikan formatting correct
3. Coba open di Word dan save ulang
4. Update PHPWord library ke versi terbaru
```

---

## 🔐 Security

✅ **Authorization** - Hanya owner proposal yang bisa download
✅ **Storage** - File disimpan di private storage folder
✅ **Validation** - Risk level di-validate sebelum process
✅ **Error Safety** - Exception handling untuk semua edge cases

---

## 📊 Architecture

```
User Request
    ↓
ProposalController::generateFilledDocument()
    ↓
ProposalTemplateFillerService::generateFilledProposal()
    ↓
1. Load template dari storage
2. Read dengan PHPWord
3. Replace placeholders
4. Save ke temp file
5. Return download response
    ↓
User downloads .docx file
```

---

## 🎓 Next Steps

1. **Edit Template** - Add placeholder ke template DOCX Anda
2. **Test Flow** - Create proposal dan download document
3. **Customize** - Edit template untuk sesuai kebutuhan
4. **Deploy** - Ready untuk production use

---

**Last Updated:** April 10, 2026  
**System:** Laravel 12 + PHPWord 1.4.0  
**Status:** ✅ Ready for Use
