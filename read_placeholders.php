<?php
$zip = new ZipArchive();
$path = __DIR__ . '/storage/app/templates/proposals/RESIKO SEDANG_RENDAH.docx';
if ($zip->open($path) === true) {
    $xml = $zip->getFromName('word/document.xml');
    preg_match_all('/<w:t[^>]*>(.*?)<\/w:t>/s', $xml, $matches);
    $cleanTexts = array_map(function($text) {
        return strip_tags($text);
    }, $matches[1]);
    
    echo "=== Signature Keyword Matches ===\n";
    foreach ($cleanTexts as $idx => $t) {
        if (preg_match('/Ketua|Sekretaris|Pembina|Kaprodi|Abednego|Yudha|Purwokerto|Menyetujui|Mengetahui/i', $t)) {
            echo "Index $idx: $t\n";
            // Print surrounding segments
            for ($i = max(0, $idx - 3); $i <= min(count($cleanTexts) - 1, $idx + 3); $i++) {
                echo "  [$i] => " . $cleanTexts[$i] . "\n";
            }
            echo "-----------------\n";
        }
    }
    $zip->close();
} else {
    echo "Failed to open docx\n";
}
