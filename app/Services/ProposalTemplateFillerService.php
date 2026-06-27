<?php

namespace App\Services;

use App\Models\Proposal;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Element\TextRun;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProposalTemplateFillerService
{
    /**
     * Generate proposal document by filling template with data
     * 
     * @param Proposal $proposal
     * @param string $riskLevel 'low' or 'high'
     * @return string Path to generated document
     */
    public function generateFilledProposal(Proposal $proposal, string $riskLevel = 'low')
    {
        // Get template filename based on risk level
        $templateFilename = $this->getTemplateFilename($proposal->risk_level);
        $templatePath = storage_path('app/templates/proposals/' . $templateFilename);

        if (!file_exists($templatePath)) {
            throw new \Exception("Template file not found: {$templateFilename}");
        }

        // Load template using PHPWord
        $phpWord = IOFactory::load($templatePath);

        // Fill placeholders with proposal data
        $this->replacePlaceholders($phpWord, $proposal);

        // Save to temporary file
        $outputPath = storage_path('app/proposals/' . $proposal->id . '_' . uniqid() . '.docx');
        @mkdir(dirname($outputPath), 0755, true);

        // Save document
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($outputPath);

        return $outputPath;
    }

    /**
     * Get template filename based on risk level
     */
    private function getTemplateFilename(string $riskLevel): string
    {
        // Check which template file is available in the folder
        $templateDir = storage_path('app/templates/proposals');
        $files = @scandir($templateDir) ?: [];

        // Filter only DOCX files
        $docxFiles = array_filter($files, function($file) {
            return strpos($file, '.docx') !== false;
        });

        if (empty($docxFiles)) {
            throw new \Exception("No template files found in storage/app/templates/proposals/");
        }

        // Search by risk level
        foreach ($docxFiles as $file) {
            $lower = strtolower($file);
            
            // For high risk
            if ($riskLevel === 'high' && strpos($lower, 'tinggi') !== false) {
                return $file;
            }
            
            // For low risk - check for 'rendah' or 'sedang'
            if ($riskLevel === 'low' && (strpos($lower, 'rendah') !== false || strpos($lower, 'sedang') !== false)) {
                return $file;
            }
        }

        // Fallback to first available template
        reset($docxFiles);
        return current($docxFiles);
    }

    /**
     * Replace placeholders in document with actual data
     */
    private function replacePlaceholders(PhpWord $phpWord, Proposal $proposal): void
    {
        $placeholders = $this->getPlaceholderMappings($proposal);

        // Iterate through all sections
        foreach ($phpWord->getSections() as $section) {
            // Replace in paragraphs
            foreach ($section->getElements() as $element) {
                $this->replaceInElement($element, $placeholders);
            }
        }
    }

    /**
     * Recursively replace placeholders in element
     */
    private function replaceInElement($element, array $placeholders): void
    {
        if (method_exists($element, 'getElements')) {
            // Container element (table, list, etc.)
            foreach ($element->getElements() as $child) {
                $this->replaceInElement($child, $placeholders);
            }
        }

        if (method_exists($element, 'getTextContent')) {
            // Get current text
            try {
                $text = $element->getTextContent();
                
                // Check if placeholder exists
                foreach ($placeholders as $placeholder => $value) {
                    if (strpos($text, $placeholder) !== false) {
                        // For TextRun elements
                        if (method_exists($element, 'setText')) {
                            $newText = str_replace($placeholder, $value, $text);
                            $element->setText($newText);
                        }
                        // For TextBlock or Paragraph with TextRuns
                        elseif (method_exists($element, 'getElements')) {
                            foreach ($element->getElements() as $run) {
                                if ($run instanceof TextRun && method_exists($run, 'getText')) {
                                    $runText = $run->getText();
                                    if (strpos($runText, $placeholder) !== false) {
                                        $newText = str_replace($placeholder, $value, $runText);
                                        $run->setText($newText);
                                    }
                                }
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                // Skip if text retrieval fails
            }
        }
    }

    /**
     * Get all placeholder mappings for the proposal
     */
    private function getPlaceholderMappings(Proposal $proposal): array
    {
        return [
            '{{NAMA_KEGIATAN}}' => $proposal->title ?? '-',
            '{{nama_kegiatan}}' => $proposal->title ?? '-',
            '{NAMA_KEGIATAN}' => $proposal->title ?? '-',
            '{nama_kegiatan}' => $proposal->title ?? '-',
            
            '{{LATAR_BELAKANG}}' => $proposal->background ?? '-',
            '{{latar_belakang}}' => $proposal->background ?? '-',
            '{LATAR_BELAKANG}' => $proposal->background ?? '-',
            '{latar_belakang}' => $proposal->background ?? '-',
            
            '{{TUJUAN}}' => $proposal->objective ?? '-',
            '{{tujuan}}' => $proposal->objective ?? '-',
            '{TUJUAN}' => $proposal->objective ?? '-',
            '{tujuan}' => $proposal->objective ?? '-',
            
            '{{ANGGARAN}}' => $this->formatCurrency($proposal->budget),
            '{{anggaran}}' => $this->formatCurrency($proposal->budget),
            '{ANGGARAN}' => $this->formatCurrency($proposal->budget),
            '{anggaran}' => $this->formatCurrency($proposal->budget),
            
            '{{TIMELINE}}' => $proposal->timeline ?? '-',
            '{{timeline}}' => $proposal->timeline ?? '-',
            '{TIMELINE}' => $proposal->timeline ?? '-',
            '{timeline}' => $proposal->timeline ?? '-',
            
            '{{TINGKAT_RISIKO}}' => ucfirst(str_replace('-', ' ', $proposal->risk_level)),
            '{{tingkat_risiko}}' => $proposal->risk_level,
            '{TINGKAT_RISIKO}' => ucfirst(str_replace('-', ' ', $proposal->risk_level)),
            '{tingkat_risiko}' => $proposal->risk_level,
            
            '{{DESKRIPSI_RISIKO}}' => $proposal->risk_description ?? '-',
            '{{deskripsi_risiko}}' => $proposal->risk_description ?? '-',
            '{DESKRIPSI_RISIKO}' => $proposal->risk_description ?? '-',
            '{deskripsi_risiko}' => $proposal->risk_description ?? '-',
            
            '{{TANGGAL_DIBUAT}}' => $proposal->created_at->format('d/m/Y') ?? '-',
            '{{tanggal_dibuat}}' => $proposal->created_at->format('d/m/Y') ?? '-',
            '{TANGGAL_DIBUAT}' => $proposal->created_at->format('d/m/Y') ?? '-',
            '{tanggal_dibuat}' => $proposal->created_at->format('d/m/Y') ?? '-',
            
            '{{NAMA_PEMBUAT}}' => $proposal->user?->name ?? '-',
            '{{nama_pembuat}}' => $proposal->user?->name ?? '-',
            '{NAMA_PEMBUAT}' => $proposal->user?->name ?? '-',
            '{nama_pembuat}' => $proposal->user?->name ?? '-',

            // Add more as needed
        ];
    }

    /**
     * Format currency value
     */
    private function formatCurrency($value): string
    {
        if (!$value) return '-';
        return 'Rp ' . number_format($value, 0, ',', '.');
    }

    /**
     * Download filled proposal document
     */
    public function downloadProposal(string $filePath, string $filename): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return response()->download($filePath, $filename . '.docx');
    }

    /**
     * Convert filled proposal to PDF (optional)
     */
    public function convertToPdf(string $docxPath): string
    {
        // This requires LibreOffice or similar - optional feature
        // For now, return the DOCX path
        return $docxPath;
    }
}
