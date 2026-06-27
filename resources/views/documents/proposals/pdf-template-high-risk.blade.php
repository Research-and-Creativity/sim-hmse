<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal Resiko Tinggi - {{ $proposal->title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #EF4444;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #EF4444;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 12px;
        }

        .risk-badge {
            display: inline-block;
            background-color: #EF4444;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin: 10px 0;
        }

        .warning-box {
            background-color: #FEE2E2;
            border-left: 4px solid #EF4444;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .warning-box p {
            color: #DC2626;
            font-size: 12px;
            font-weight: bold;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            background-color: #EF4444;
            color: white;
            padding: 10px 15px;
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 14px;
        }

        .section-content {
            padding: 0 15px;
            text-align: justify;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            padding: 10px;
            border-left: 3px solid #EF4444;
        }

        .info-label {
            font-weight: bold;
            color: #EF4444;
            font-size: 12px;
        }

        .info-value {
            margin-top: 5px;
            font-size: 13px;
            color: #444;
        }

        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-line {
            display: inline-block;
            width: 150px;
            border-top: 1px solid #000;
            text-align: center;
            font-size: 11px;
            margin-top: 5px;
        }

        .signature-block {
            display: inline-block;
            width: 48%;
            margin-right: 2%;
            vertical-align: top;
        }

        .signature-block:last-child {
            margin-right: 0;
        }

        .metadata {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 11px;
            color: #666;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>PROPOSAL KEGIATAN</h1>
            <p>HIMPUNAN MAHASISWA SOFTWARE ENGINEERING</p>
            <p>TELKOM UNIVERSITY PURWOKERTO</p>
            <span class="risk-badge">⚠️ Resiko Tinggi</span>
        </div>

        <!-- Warning Box -->
        <div class="warning-box">
            <p>⚠️ PERHATIAN: Proposal ini termasuk kategori RESIKO TINGGI dan memerlukan persetujuan dari semua pihak terkait.</p>
        </div>

        <!-- Title -->
        <div class="section">
            <h2 style="font-size: 18px; color: #EF4444; margin-bottom: 10px;">{{ $proposal->title }}</h2>
        </div>

        <!-- Info Grid -->
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">PEMBUAT PROPOSAL</div>
                <div class="info-value">{{ $proposal->user->name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">TANGGAL PEMBUATAN</div>
                <div class="info-value">{{ $proposal->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">ANGGARAN</div>
                <div class="info-value">Rp {{ number_format($proposal->budget, 0, ',', '.') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">TIMELINE</div>
                <div class="info-value">{{ $proposal->timeline }}</div>
            </div>
        </div>

        <!-- Latar Belakang -->
        <div class="section">
            <div class="section-title">LATAR BELAKANG</div>
            <div class="section-content">
                {!! nl2br(e($proposal->background)) !!}
            </div>
        </div>

        <!-- Tujuan -->
        <div class="section">
            <div class="section-title">TUJUAN</div>
            <div class="section-content">
                {!! nl2br(e($proposal->objective)) !!}
            </div>
        </div>

        <!-- Identifikasi Risiko -->
        <div class="section">
            <div class="section-title">IDENTIFIKASI & MITIGASI RISIKO (PENTING!)</div>
            <div class="section-content">
                <p style="margin-bottom: 10px; font-weight: bold; color: #EF4444;">Risiko yang Diidentifikasi:</p>
                {!! nl2br(e($proposal->risk_description)) !!}
            </div>
        </div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div style="text-align: center; margin-bottom: 40px; font-weight: bold; color: #EF4444;">
                PERSETUJUAN DARI SEMUA PIHAK DIPERLUKAN:
            </div>

            <div style="text-align: center; margin-bottom: 30px;">
                <div class="signature-block">
                    <p style="font-size: 11px; margin-bottom: 50px;">Ketua Panitia</p>
                    <div class="signature-line"></div>
                </div>
                <div class="signature-block">
                    <p style="font-size: 11px; margin-bottom: 50px;">Sekretaris</p>
                    <div class="signature-line"></div>
                </div>
            </div>

            <div style="text-align: center; margin-bottom: 30px;">
                <div class="signature-block">
                    <p style="font-size: 11px; margin-bottom: 50px;">Ketua HMSE</p>
                    <div class="signature-line"></div>
                </div>
                <div class="signature-block">
                    <p style="font-size: 11px; margin-bottom: 50px;">Pembina HMSE</p>
                    <div class="signature-line"></div>
                </div>
            </div>

            <div style="text-align: center;">
                <p style="font-size: 11px; margin-bottom: 50px;">Kaprodi RPL</p>
                <div style="display: inline-block; width: 150px;">
                    <div class="signature-line"></div>
                </div>
            </div>
        </div>

        <!-- Metadata -->
        <div class="metadata">
            <p><strong>ID Proposal:</strong> {{ $proposal->id }}</p>
            <p><strong>Status:</strong> {{ ucfirst($proposal->status) }}</p>
            <p><strong>Kategori Risiko:</strong> Tinggi</p>
            <p><strong>Terakhir Diperbarui:</strong> {{ $proposal->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>
</html>
