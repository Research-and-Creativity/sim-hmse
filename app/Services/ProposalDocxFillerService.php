<?php

namespace App\Services;

use ZipArchive;

class ProposalDocxFillerService
{
    /**
     * Generate filled DOCX from template using form data (no DB required)
     *
     * @param array $data  Form data from the create form
     * @return string  Path to the generated filled DOCX file
     */
    public function generateFromFormData(array $data): string
    {
        $riskLevel = $data['risk_level'] ?? 'low';
        $templatePath = $this->getTemplatePath($riskLevel);

        if (!file_exists($templatePath)) {
            throw new \Exception("Template file tidak ditemukan: {$templatePath}");
        }

        // Copy template to a temp file
        $outputDir = storage_path('app/proposals/temp');
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        $outputPath = $outputDir . '/proposal_' . uniqid() . '.docx';
        copy($templatePath, $outputPath);

        // Open DOCX (it's a ZIP), replace text in word/document.xml
        $this->replaceInDocx($outputPath, $data);

        return $outputPath;
    }

    /**
     * Get the template file path based on risk level
     */
    private function getTemplatePath(string $riskLevel): string
    {
        $dir = storage_path('app/templates/proposals');

        if ($riskLevel === 'high') {
            return $dir . '/RESIKO TINGGI.docx';
        }

        return $dir . '/RESIKO SEDANG_RENDAH.docx';
    }

    /**
     * Replace placeholder text inside a DOCX file
     */
    private function replaceInDocx(string $docxPath, array $data): void
    {
        $zip = new ZipArchive();

        if ($zip->open($docxPath) !== true) {
            throw new \Exception("Gagal membuka file DOCX");
        }

        // Read document.xml
        $xml = $zip->getFromName('word/document.xml');

        if ($xml === false) {
            $zip->close();
            throw new \Exception("Gagal membaca document.xml dari DOCX");
        }

        // First, merge split XML runs so placeholders aren't broken across runs
        $xml = $this->mergeRuns($xml);

        // Build replacement map
        $replacements = $this->buildReplacements($data);

        // Do the replacements
        foreach ($replacements as $search => $replace) {
            $xml = str_replace(
                htmlspecialchars($search, ENT_XML1 | ENT_QUOTES, 'UTF-8'),
                htmlspecialchars($replace, ENT_XML1 | ENT_QUOTES, 'UTF-8'),
                $xml
            );
            // Also try without XML encoding (some text is stored raw)
            $xml = str_replace($search, $replace, $xml);
        }

        // Write back
        $zip->addFromString('word/document.xml', $xml);
        $zip->close();
    }

    /**
     * Merge adjacent w:r (run) elements that have the same formatting
     * This fixes the issue where Word splits text like "NAMA KEGIATAN"
     * into multiple runs: "NAMA", " ", "KEGIATAN"
     */
    private function mergeRuns(string $xml): string
    {
        // Match all text content within runs and merge adjacent runs with same properties
        // This is a simplified approach: we merge the text within <w:r> tags that follow
        // each other when their <w:rPr> (run properties) are identical

        // Pattern to normalize whitespace preservation
        $xml = preg_replace('/<w:t>/', '<w:t xml:space="preserve">', $xml);

        // More aggressive: find sequences of <w:r> and merge their <w:t> text
        // when the runs have the same rPr
        $xml = preg_replace_callback(
            '/(<w:r\b[^>]*>(?:<w:rPr>.*?<\/w:rPr>)?<w:t[^>]*>)(.*?)(<\/w:t><\/w:r>)(\s*<w:r\b[^>]*>(?:<w:rPr>.*?<\/w:rPr>)?<w:t[^>]*>)(.*?)(<\/w:t><\/w:r>)/s',
            function ($matches) {
                // Check if run properties are the same by comparing them
                // For simplicity, merge all adjacent runs
                $text1 = $matches[2];
                $text2 = $matches[5];
                return $matches[1] . $text1 . $text2 . $matches[3];
            },
            $xml
        );

        // Run multiple passes to merge more than 2 adjacent runs
        for ($i = 0; $i < 5; $i++) {
            $prev = $xml;
            $xml = preg_replace_callback(
                '/(<w:r\b[^>]*>(?:<w:rPr>.*?<\/w:rPr>)?<w:t[^>]*>)(.*?)(<\/w:t><\/w:r>)(\s*<w:r\b[^>]*>(?:<w:rPr>.*?<\/w:rPr>)?<w:t[^>]*>)(.*?)(<\/w:t><\/w:r>)/s',
                function ($matches) {
                    $text1 = $matches[2];
                    $text2 = $matches[5];
                    return $matches[1] . $text1 . $text2 . $matches[3];
                },
                $xml
            );
            if ($xml === $prev) break;
        }

        return $xml;
    }

    /**
     * Build the text replacement map from form data
     */
    private function buildReplacements(array $data): array
    {
        $title       = $data['title'] ?? 'Nama Kegiatan';
        $background  = $data['background'] ?? '-';
        $objective   = $data['objective'] ?? '-';
        $riskDesc    = $data['risk_description'] ?? '-';
        $budget      = isset($data['budget']) ? 'Rp ' . number_format((float)$data['budget'], 0, ',', '.') : '-';
        $timeline    = $data['timeline'] ?? '-';
        $ketuaPanitia = 'Nama Ketua';
        $sekretaris = 'Nama Sekretaris';
        if (isset($data['panitia_jabatan'])) {
            foreach ($data['panitia_jabatan'] as $index => $jabatan) {
                if (strtolower(trim($jabatan)) === 'ketua panitia') {
                    $ketuaPanitia = $data['panitia_nama'][$index] ?? 'Nama Ketua';
                }
                if (strtolower(trim($jabatan)) === 'sekretaris') {
                    $sekretaris = $data['panitia_nama'][$index] ?? 'Nama Sekretaris';
                }
            }
        }
        $tema        = $data['tema'] ?? '-';
        $tanggal     = $data['tanggal'] ?? now()->format('d F Y');
        $waktu       = $data['waktu'] ?? '-';
        $tempat      = $data['tempat'] ?? '-';
        $manfaat     = $data['manfaat'] ?? '-';
        $peserta     = $data['peserta'] ?? 'Mahasiswa Prodi S1 Rekayasa Perangkat Lunak';
        $penutup     = $data['penutup'] ?? 'Demikian proposal ini kami susun, besar harapan kami kegiatan ini dapat terlaksana dengan baik. Atas perhatian dan dukungannya kami ucapkan terima kasih.';

        return [
            // Title - appears multiple times in template
            'NAMA KEGIATAN'               => strtoupper($title),
            'Nama kegiatan ini adalah.'   => 'Nama kegiatan ini adalah ' . $title . '.',

            // Tema
            'Tema kegiatan ini adalah "  "' => 'Tema kegiatan ini adalah "' . ($tema !== '-' ? $tema : $title) . '"',

            // Latar Belakang - the template seems to have empty space after the heading
            // We can't easily replace empty content, but we fill the objective/tujuan

            // Tujuan
            'Tujuan dari kegiatan ini adalah:' => 'Tujuan dari kegiatan ini adalah: ' . $objective,

            // Manfaat
            'Manfaat dari kegiatan ini adalah :' => 'Manfaat dari kegiatan ini adalah: ' . $manfaat,

            // Waktu & Tempat - table cells
            'Hari/Tanggal'     => 'Hari/Tanggal',  // keep label, fill via cell value approach

            // Penutup
            'Harap diisi'      => $penutup,

            // Halaman Pengesahan
            'Purwokerto, …………………………..' => 'Purwokerto, ' . $tanggal,
            'Nama Ketua'       => $ketuaPanitia,
            'Nama Sekretaris'  => $sekretaris,
        ];
    }
}
