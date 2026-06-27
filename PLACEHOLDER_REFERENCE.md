% TEMPLATE PLACEHOLDER QUICK REFERENCE

# Available Placeholders for Template DOCX

Gunakan placeholder berikut di template DOCX Anda. Ketika proposal di-generate, placeholder akan otomatis diganti dengan data dari form.

---

## Format yang Didukung

Semua format ini didukung dan case-insensitive:

| Format | Contoh | Hasil |
|--------|--------|-------|
| `{{var}}` | `{{nama_kegiatan}}` | Workshop UI/UX Design 2026 |
| `{var}` | `{nama_kegiatan}` | Workshop UI/UX Design 2026 |
| Uppercase | `{{NAMA_KEGIATAN}}` | Workshop UI/UX Design 2026 |
| Lowercase | `{{nama_kegiatan}}` | Workshop UI/UX Design 2026 |

---

## Placeholder List

### ✅ Informasi Dasar Kegiatan

| Placeholder | Field Form | Contoh Output |
|---|---|---|
| `{{nama_kegiatan}}` atau `{NAMA_KEGIATAN}` | Nama Kegiatan | Workshop UI/UX Design 2026 |
| `{{latar_belakang}}` | Latar Belakang | Kegiatan ini dirancang untuk... |
| `{{tujuan}}` | Tujuan Kegiatan | Meningkatkan kemampuan mahasiswa... |
| `{{tingkat_risiko}}` | Risk Level Selection | Rendah atau Tinggi |
| `{{deskripsi_risiko}}` | Risk Description | Potensi peserta kurang, tapi... |

### 💰 Keuangan

| Placeholder | Field Form | Contoh Output |
|---|---|---|
| `{{anggaran}}` | Anggaran | Rp 3.200.000 |

### 📅 Waktu & Tanggal

| Placeholder | Field Form | Contoh Output |
|---|---|---|
| `{{tanggal_dibuat}}` | Created At (Auto) | 10/04/2026 |
| `{{timeline}}` | Timeline | 15 April 2026 s/d 30 April 2026 |

### 👤 Informasi Pembuat

| Placeholder | Field Form | Contoh Output |
|---|---|---|
| `{{nama_pembuat}}` | User Name (Auto) | Ahmad Fauzi |

---

## 📝 Copy-Paste Examples

### Contoh 1: Simple Template

```docx
═════════════════════════════════════════════
               PROPOSAL KEGIATAN
═════════════════════════════════════════════

Nama Kegiatan: {{nama_kegiatan}}
Dibuat: {{tanggal_dibuat}}
Oleh: {{nama_pembuat}}

LATAR BELAKANG
──────────────
{{latar_belakang}}

TUJUAN
──────
{{tujuan}}

TINGKAT RISIKO: {{tingkat_risiko}}
CATATAN RISIKO: {{deskripsi_risiko}}

ANGGARAN: {{anggaran}}
```

### Contoh 2: Detailed Template

```docx
PROPOSAL KEGIATAN HMSE
════════════════════════════════════════

IDENTITAS KEGIATAN
──────────────────
Nama          : {{nama_kegiatan}}
Tanggal       : {{tanggal_dibuat}}
Pengusul      : {{nama_pembuat}}
Risiko Level  : {{tingkat_risiko}}

PENDAHULUAN
──────────
Latar Belakang:
{{latar_belakang}}

Tujuan Kegiatan:
{{tujuan}}

RENCANA KEGIATAN
────────────────
Timeline: {{timeline}}

ASPEK KEUANGAN
──────────────
Total Anggaran: {{anggaran}}

MANAJEMEN RISIKO
────────────────
Tingkat Risiko: {{tingkat_risiko}}

Strategi Mitigasi:
{{deskripsi_risiko}}

════════════════════════════════════════
```

### Contoh 3: Table Format

```
Informasi Proposal
┌─────────────────────────────────────┬──────────────────────┐
│ Field                               │ Isi                  │
├─────────────────────────────────────┼──────────────────────┤
│ Nama Kegiatan                       │ {{nama_kegiatan}}    │
│ Latar Belakang                      │ {{latar_belakang}}   │
│ Tujuan                              │ {{tujuan}}           │
│ Anggaran                            │ {{anggaran}}         │
│ Timeline                            │ {{timeline}}         │
│ Tingkat Risiko                      │ {{tingkat_risiko}}   │
│ Deskripsi Risiko                    │ {{deskripsi_risiko}} │
└─────────────────────────────────────┴──────────────────────┘
```

---

## 🎯 Step-by-Step: Membuat Template dengan Placeholder

### 1. Buka Template di Word
```
Open: storage/app/templates/proposals/RESIKO TINGGI.docx
(atau RESIKO SEDANG_RENDAH.docx)
```

### 2. Positioning Placeholder

Di mana pun Anda ingin data muncul, ketik placeholder:

**BEFORE:**
```
Kegiatan ini bertujuan untuk:
_________________________________
```

**AFTER (with placeholder):**
```
Kegiatan ini bernama: {{nama_kegiatan}}

Deskripsi lengkapnya:
{{latar_belakang}}

Target utama adalah:
{{tujuan}}
```

### 3. Formatting

- Placeholder bisa punya formatting (bold, italic, warna, dll)
- Formatting akan tetap di hasil akhir
- Text dari form akan inherit formatting placeholder

**Contoh:**
```
NAMA KEGIATAN: ***{{nama_kegiatan}}***
(bold)            (akan bold di hasil)

ANGGARAN: **{{anggaran}}**
(12pt)            (akan 12pt di hasil)
```

### 4. Placement Flexibility

Placeholder bisa di:
- ✅ Paragraph text
- ✅ Table cells
- ✅ Heading
- ✅ Lists
- ❌ Header/Footer (khusus PHPWord 1.4.0 belum fully support)
- ❌ Inside images/shapes

### 5. Save & Upload

```
1. Edit template di Word
2. File → Save
3. Upload ke: storage/app/templates/proposals/
4. Replace file lama atau taro file baru
5. Clear cache (auto-clear on first access)
```

---

## ⚠️ Common Mistakes

### ❌ SALAH - Dengan space/typo

```
{{ nama_kegiatan }}    ← Extra spaces
{nama_kegiatan}        ← Tapi format ini juga ok
{{nama_kegiants}}      ← Typo!
{{nama kegiatan}}      ← Space di tengah!
```

### ✅ BENAR

```
{{nama_kegiatan}}      ← Exactly like this
{nama_kegiatan}        ← Or like this
{{NAMA_KEGIATAN}}      ← Uppercase ok
```

### ❌ SALAH - Using field names yang tidak ada

```
{{koordinator}}        ← Field ini tidak ada di form
{{email_pembuat}}      ← Field ini tidak ada
{{custom_field}}       ← Custom fields belum support
```

### ✅ BENAR - Hanya gunakan placeholder yang ada di list

```
{{nama_kegiatan}}      ✅ ADA
{{latar_belakang}}     ✅ ADA
{{anggaran}}           ✅ ADA
```

---

## 🧪 Testing Placeholder

### Sebelum Deploy ke Production

1. **Buat Proposal Test**
   ```
   Nama: Test Kegiatan 123
   Anggaran: 1000000
   Risiko: Rendah
   Latar: Lorem ipsum test
   Tujuan: Test tujuan
   ```

2. **Download Document**
   ```
   Klik: Download Template Isi
   ```

3. **Check Output**
   ```
   Buka file .docx
   Verify semua placeholder sudah terisi dengan benar
   Check formatting tetap ok
   ```

4. **If Error**
   ```
   - Cek placeholder spelling di template
   - Cek data form tidak kosong
   - Check error log
   - Try cache:clear
   ```

---

## 📊 Data Type Formatting

Beberapa field punya formatting khusus:

### Anggaran
**Format:** Rp X.XXX.XXX (dengan pemisah ribuan)

Example:
```
User input: 3200000
Placeholder result: Rp 3.200.000
```

### Tanggal Dibuat
**Format:** DD/MM/YYYY

Example:
```
Created: 2026-04-10T14:30:00
Placeholder result: 10/04/2026
```

### Tingkat Risiko
**Capitalized:** Rendah atau Tinggi

Example:
```
Database: low
Placeholder result: Rendah

Database: high  
Placeholder result: Tinggi
```

---

## 🚀 Best Practices

1. **Use Consistent Naming**
   - Keep placeholder names descriptive
   - Use snake_case: `{{nama_kegiatan}}`
   - NOT camelCase: `{{namaKegiatan}}`

2. **Document Your Templates**
   - Add comment di template: "Use {{nama_kegiatan}} for proposal name"
   - Keep placeholder list updated
   - Version your templates

3. **Test Before Deployment**
   - Create test proposal
   - Download & verify
   - Fix if needed
   - Then go live

4. **Backup Original**
   - Keep original template backup
   - Before updating
   - In case need to rollback

5. **Group Related Data**
   ```
   ✅ BAIK:
   Nama: {{nama_kegiatan}}
   Latar: {{latar_belakang}}
   Tujuan: {{tujuan}}
   
   ❌ BURUK:
   {{nama_kegiatan}}
   [random field]
   {{latar_belakang}}
   [unrelated text]
   ```

---

## 🔍 Debugging

### Problem: Template tidak terisi

**Cek:**
1. File template ada di folder? 
   - Path: `storage/app/templates/proposals/`
2. Nama file benar?
   - `RESIKO TINGGI.docx` atau `RESIKO SEDANG_RENDAH.docx`
3. Proposal punya data (form tidak kosong)?
4. Placeholder spelling benar?

**Logs:**
```
storage/logs/laravel.log
← Check untuk error messages
```

### Problem: Placeholder muncul tapi tidak terisi

**Cek:**
1. Placeholder format benar? `{{var}}` tidak `{{ var }}`
2. Spacing? No extra spaces
3. Typo dalam placeholder?
4. Field data dari form kosong?

**Solution:**
```
1. Edit template
2. Use exact placeholder: {{nama_kegiatan}}
3. Clear cache
4. Test lagi
```

---

## 📞 Support

Reference files:
- [TEMPLATE_USAGE_GUIDE.md](TEMPLATE_USAGE_GUIDE.md) - Full guide
- [ProposalTemplateFillerService.php](app/Services/ProposalTemplateFillerService.php) - Implementation
- [ProposalController.php](app/Http/Controllers/ProposalController.php) - Controller methods

Check error messages:
```
storage/logs/laravel.log
```

---

**Last Updated:** April 10, 2026  
**Library:** PHPWord 1.4.0  
**Status:** ✅ Production Ready
