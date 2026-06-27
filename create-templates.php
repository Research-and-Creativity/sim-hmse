<?php
/**
 * Script untuk membuat template DOCX files
 * Jalankan: php create-templates.php
 */

$templateDir = __DIR__ . '/storage/app/templates/proposals';
@mkdir($templateDir, 0755, true);

// Data template
$templates = [
    'template-proposal-rendah.docx' => 'RISIKO RENDAH',
    'template-proposal-tinggi.docx' => 'RISIKO TINGGI'
];

foreach ($templates as $filename => $riskType) {
    $filepath = $templateDir . '/' . $filename;
    
    $zip = new ZipArchive();
    if ($zip->open($filepath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
        // [Content_Types].xml
        $contentTypes = <<<XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
<Default Extension="xml" ContentType="application/xml"/>
<Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>
</Types>
XML;
        $zip->addFromString('[Content_Types].xml', $contentTypes);
        
        // _rels/.rels
        $rels = <<<XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="word/document.xml"/>
</Relationships>
XML;
        $zip->addFromString('_rels/.rels', $rels);
        
        // word/document.xml
        $document = <<<XML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
<w:body>
<w:p><w:r><w:t>PROPOSAL KEGIATAN - {$riskType}</w:t></w:r></w:p>
<w:p><w:r><w:t></w:t></w:r></w:p>
<w:p><w:r><w:t>Template standar HMSE untuk kegiatan dengan tingkat risiko: {$riskType}</w:t></w:r></w:p>
<w:p><w:r><w:t></w:t></w:r></w:p>
<w:p><w:r><w:rPr><w:b/></w:rPr><w:t>PETUNJUK PENGGUNAAN:</w:t></w:r></w:p>
<w:p><w:r><w:t>1. Download template ini dari sistem</w:t></w:r></w:p>
<w:p><w:r><w:t>2. Edit sesuai dengan data kegiatan Anda</w:t></w:r></w:p>
<w:p><w:r><w:t>3. Simpan dan gunakan sebagai referensi</w:t></w:r></w:p>
<w:p><w:r><w:t>4. Sistem akan menghasilkan PDF resmi untuk persetujuan di dashboard</w:t></w:r></w:p>
</w:body>
</w:document>
XML;
        $zip->addFromString('word/document.xml', $document);
        $zip->close();
        
        echo "✓ Created: {$filename}\n";
    } else {
        echo "✗ Failed to create: {$filename}\n";
    }
}

echo "\n✓ All template files created successfully!\n";
echo "Location: {$templateDir}/\n";
