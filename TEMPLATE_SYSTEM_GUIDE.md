# 📋 Proposal Template System Guide

## Overview
The proposal system now supports a hybrid approach:
1. **Auto-generated PDF templates** - System creates professional PDFs based on form data
2. **User-provided DOCX templates** - Reference templates for flexible workflows

---

## 🚀 Getting Started

### Step 1: Prepare Your Template Files

Create or customize your DOCX template files:

- **template-proposal-rendah.docx** - For low-risk proposals
- **template-proposal-tinggi.docx** - For high-risk proposals

These can include:
- Your organization's header/footer
- Standard formatting
- Placeholder sections
- Company logos/branding

### Step 2: Upload Template Files

Upload the DOCX files to this folder:
```
/storage/app/templates/proposals/
```

**File Structure:**
```
storage/
├── app/
│   └── templates/
│       └── proposals/
│           ├── template-proposal-rendah.docx
│           └── template-proposal-tinggi.docx
```

### Step 3: Access Templates from Proposal Form

Users can now:

1. Go to **Dashboard → Create Proposal**
2. In "Informasi Umum" section, select risk level:
   - ✅ Resiko Rendah (Low Risk)
   - ✅ Resiko Tinggi (High Risk)
3. Click the corresponding **Download Template** button
4. Templates are downloaded to user's computer

---

## 📥 Download URLs

Templates are accessible via these routes:

```
GET /proposals/template/low
- Downloads: template-proposal-rendah.docx

GET /proposals/template/high
- Downloads: template-proposal-tinggi.docx
```

---

## 🔧 Controller Method

**File:** `app/Http/Controllers/ProposalController.php`

```php
public function downloadTemplate(string $riskLevel)
{
    $filename = $riskLevel === 'high' 
        ? 'template-proposal-tinggi.docx'
        : 'template-proposal-rendah.docx';

    $filePath = 'templates/proposals/' . $filename;

    if (!Storage::exists($filePath)) {
        return back()->with('error', 'File template tidak ditemukan.');
    }

    return Storage::download($filePath, $filename);
}
```

**Route:** `routes/web.php`
```php
Route::get('/proposals/template/{riskLevel}', [ProposalController::class, 'downloadTemplate'])
    ->name('proposals.download-template');
```

---

## 🎯 Workflow

### For Users Creating Proposals:

1. Navigate to Create Proposal form
2. Fill in basic information (name, theme, date, etc.)
3. Select Risk Level (Rendah/Tinggi)
4. Download corresponding template if needed
5. Complete remaining sections
6. Submit proposal for approval

### System Features:

✅ **Dynamic Template Selection** - Template chosen based on risk level  
✅ **Auto-Generated PDFs** - Professional PDFs created matching template style  
✅ **Approval Workflow** - 5-level approval chain (Ketua Panitia → Pembina → Kaprodi)  
✅ **Digital Signatures** - Support for signature data in approvals  
✅ **Version Control** - Draft/Final PDF templates  

---

## 📊 Risk Level Matrix

| Risk Level | Use Case | Template Name | Requirements |
|---|---|---|---|
| **Rendah (Low)** | Simple events, workshops, seminars | template-proposal-rendah.docx | Basic stakeholder info |
| **Tinggi (High)** | Complex events, external coordination, large budgets | template-proposal-tinggi.docx | Detailed risk assessment |

---

## ⚠️ Error Handling

### If template file is not found:

**Error:** "File template tidak ditemukan."

**Solution:**
1. Verify files exist in `/storage/app/templates/proposals/`
2. Check file names match exactly:
   - `template-proposal-rendah.docx`
   - `template-proposal-tinggi.docx`
3. Clear cache: `php artisan cache:clear`

---

## 🔗 Related Files

| File | Purpose |
|---|---|
| `app/Models/Proposal.php` | Proposal model with relationships |
| `app/Http/Controllers/ProposalController.php` | Controller with CRUD & template logic |
| `app/Services/ProposalGeneratorService.php` | PDF generation logic |
| `resources/views/pages/dashboard/proposal/create.blade.php` | Proposal creation form |
| `resources/views/documents/proposals/*` | PDF templates (Blade format) |
| `storage/app/templates/proposals/` | DOCX template storage |

---

## 💡 Tips

- **Template Customization:** Edit DOCX templates to match your organization's style
- **Versioning:** Keep backup copies of templates before modifications
- **Testing:** Test template downloads before sharing with users
- **Documentation:** Add internal notes to templates for users' reference

---

## 🚨 Important Notes

1. Templates must be in **DOCX format** (Word 2007+)
2. File names are **case-sensitive** on Linux servers
3. Template folder is **not publicly accessible** (good for security)
4. Downloads use Laravel's Storage facade (supports cloud storage)
5. Cache clearing needed after adding/updating template files

---

**Last Updated:** $(date)  
**System Version:** Laravel 12 with Filament 5.0
