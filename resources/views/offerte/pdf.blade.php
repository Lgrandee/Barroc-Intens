<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Offerte PDF</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.7;
            color: #1f2937;
            background: #fff;
            padding: 40px;
        }

        /* Page break */
        .page-break { page-break-after: always; }

        /* === COVER PAGE === */
        .cover-page {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: #fff;
            border-bottom: 5px solid #000;
        }
        .cover-logo { margin-bottom: 40px; }
        .cover-logo img { max-width: 180px; height: auto; }
        .cover-title {
            font-size: 48px;
            font-weight: bold;
            color: #000;
            margin: 40px 0 20px 0;
            letter-spacing: -0.5px;
        }
        .cover-subtitle {
            font-size: 24px;
            color: #fbbf24;
            margin-bottom: 60px;
            font-weight: 600;
        }
        .cover-info {
            font-size: 13px;
            color: #666;
            line-height: 1.8;
            margin-top: 60px;
        }
        .cover-info-item {
            margin: 15px 0;
        }
        .cover-info-label {
            font-weight: bold;
            color: #000;
        }

        /* === HEADER === */
        .pdf-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 0 20px 0;
            border-bottom: 3px solid #000;
            margin-bottom: 25px;
        }
        .pdf-header-logo { width: 100px; }
        .pdf-header-logo img { max-width: 100%; height: auto; }
        .pdf-header-company {
            text-align: right;
            font-size: 11px;
        }
        .pdf-header-company-name {
            font-size: 13px;
            font-weight: bold;
            color: #000;
        }
        .pdf-header-company-contact {
            font-size: 11px;
            margin-top: 4px;
            color: #666;
        }

        /* === TYPOGRAPHY === */
        h1 {
            font-size: 28px;
            margin: 25px 0 15px 0;
            color: #000;
            font-weight: bold;
            letter-spacing: -0.3px;
        }
        h2 {
            font-size: 14px;
            margin: 25px 0 12px 0;
            padding: 10px 0 8px 0;
            border-bottom: 3px solid #fbbf24;
            color: #000;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        h3 {
            font-size: 12px;
            margin: 15px 0 8px 0;
            color: #000;
            font-weight: bold;
        }

        p { margin-bottom: 10px; }

        /* === SECTIONS === */
        .info-section {
            background: #f9fafb;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #fbbf24;
            border-radius: 2px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 15px 0;
        }
        .info-item {
            display: flex;
            flex-direction: column;
        }
        .info-label {
            font-weight: bold;
            color: #000;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 12px;
            color: #374151;
        }

        /* === TABLES === */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 11px;
        }
        th {
            background: #000;
            color: #fff;
            font-weight: bold;
            padding: 12px;
            text-align: left;
            border: none;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        tr:nth-child(even) { background: #f9fafb; }

        /* === LISTS === */
        ul {
            margin: 12px 0 12px 24px;
            padding: 0;
        }
        li {
            margin-bottom: 6px;
            color: #374151;
        }

        /* === BOXES === */
        .terms-box {
            background: #fef3c7;
            padding: 15px;
            margin: 15px 0;
            border-left: 5px solid #fbbf24;
            border-radius: 2px;
            font-size: 11px;
        }
        .terms-box p {
            margin-bottom: 8px;
            color: #78350f;
        }
        .terms-box strong {
            color: #000;
            font-weight: bold;
        }
        .terms-box ul {
            margin: 10px 0 10px 24px;
        }
        .terms-box li {
            color: #78350f;
            margin-bottom: 5px;
        }

        /* === TOTALS BOX === */
        .totals-box {
            background: #f9fafb;
            padding: 20px;
            margin: 20px 0;
            border-left: 5px solid #fbbf24;
            border-radius: 2px;
            width: 50%;
            margin-left: auto;
        }
        .totals-box table {
            margin: 0;
        }
        .totals-box td {
            padding: 8px 12px;
            border: none;
        }
        .total-label {
            font-weight: normal;
        }
        .total-value {
            font-weight: bold;
            text-align: right;
        }
        .grand-total {
            font-size: 13px;
            border-top: 2px solid #fbbf24;
            font-weight: bold;
        }

        /* === FOOTER === */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 10px;
            text-align: center;
            color: #999;
        }
    </style>
</head>
<body>
    <!-- COVER PAGE -->
    <div class="cover-page">
        <div class="cover-logo">
            <img src="file://{{ public_path('img/Logo6_groot.png') }}" alt="Barroc Intens">
        </div>
        <div class="cover-title">OFFERTE</div>
        <div class="cover-subtitle">#OFF-{{ date('Y', strtotime($offerte->created_at)) }}-{{ str_pad($offerte->id, 3, '0', STR_PAD_LEFT) }}</div>

        <div class="cover-info">
            <div class="cover-info-item">
                <span class="cover-info-label">Klant:</span> {{ $offerte->customer->name_company ?? 'Onbekend' }}
            </div>
            <div class="cover-info-item">
                <span class="cover-info-label">Offertedatum:</span> {{ \Carbon\Carbon::parse($offerte->created_at)->format('d F Y') }}
            </div>
            <div class="cover-info-item">
                <span class="cover-info-label">Geldig tot:</span> {{ \Carbon\Carbon::parse($offerte->created_at)->addDays(30)->format('d F Y') }}
            </div>
            <div class="cover-info-item">
                <span class="cover-info-label">Status:</span> <strong>{{ ucfirst($offerte->status) }}</strong>
            </div>
        </div>
    </div>

    <div class="page-break"></div>
    <!-- CONTENT PAGE -->
    <!-- Header with logo -->
    <div class="pdf-header">
        <div class="pdf-header-logo">
            <img src="file://{{ public_path('img/Logo6_groot.png') }}" alt="Barroc Intens">
        </div>
        <div class="pdf-header-company">
            <div class="pdf-header-company-name">BARROC INTENS</div>
            <div class="pdf-header-company-contact">
                info@barrocintens.nl<br>
                +31 (0)76 587 7400
            </div>
        </div>
    </div>

    <h1>Offerte #OFF-{{ date('Y', strtotime($offerte->created_at)) }}-{{ str_pad($offerte->id, 3, '0', STR_PAD_LEFT) }}</h1>

    <h2>Offertegegevens</h2>
    <div class="info-grid">
        <div class="info-item">
            <span class="info-label">Klant</span>
            <span class="info-value">{{ $offerte->customer->name_company ?? 'Onbekend' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Contactpersoon</span>
            <span class="info-value">{{ $offerte->customer->contact_person ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">E-mail</span>
            <span class="info-value">{{ $offerte->customer->email ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Telefoon</span>
            <span class="info-value">{{ $offerte->customer->phone_number ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Offertedatum</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($offerte->created_at)->format('d F Y') }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Geldig tot</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($offerte->created_at)->addDays(30)->format('d F Y') }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Adres</span>
            <span class="info-value">{{ $offerte->customer->address ?? 'N/A' }}, {{ $offerte->customer->zipcode ?? '' }} {{ $offerte->customer->city ?? '' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Status</span>
            <span class="info-value"><strong>{{ ucfirst($offerte->status) }}</strong></span>
        </div>
    </div>

    <h2>Producten & Diensten</h2>
    <table>
        <thead>
            <tr>
                <th>Product / Dienst</th>
                <th style="width: 15%; text-align: center;">Aantal</th>
                <th style="width: 20%; text-align: right;">Prijs per stuk</th>
                <th style="width: 20%; text-align: right;">Totaal</th>
            </tr>
        </thead>
        <tbody>
        @php
            $totalExVat = 0;
        @endphp
        @foreach($offerte->products as $product)
            @php
                $quantity = $product->pivot->quantity ?? 1;
                $lineTotal = $product->price * $quantity;
                $totalExVat += $lineTotal;
            @endphp
            <tr>
                <td>{{ $product->product_name }}</td>
                <td style="text-align: center;">{{ $quantity }}</td>
                <td style="text-align: right;">€{{ number_format($product->price, 2, ',', '.') }}</td>
                <td style="text-align: right;">€{{ number_format($lineTotal, 2, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @php
        $vat = $totalExVat * 0.21;
        $totalIncVat = $totalExVat + $vat;
    @endphp

    <div class="totals-box">
        <table>
            <tr>
                <td style="padding: 5px;"><span class="total-label">Subtotaal (excl. BTW):</span></td>
                <td style="padding: 5px; text-align: right;"><span class="total-value">€{{ number_format($totalExVat, 2, ',', '.') }}</span></td>
            </tr>
            <tr>
                <td style="padding: 5px;"><span class="total-label">BTW (21%):</span></td>
                <td style="padding: 5px; text-align: right;"><span class="total-value">€{{ number_format($vat, 2, ',', '.') }}</span></td>
            </tr>
            <tr class="grand-total">
                <td style="padding: 10px 5px; border-top: 2px solid #fbbf24;"><span class="total-label">Totaal (incl. BTW):</span></td>
                <td style="padding: 10px 5px; border-top: 2px solid #fbbf24; text-align: right;">€{{ number_format($totalIncVat, 2, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <h2>Installatie & Voorwaarden</h2>
    <div class="terms-box">
        <p><strong>Installatiekosten en voorwaarden</strong></p>
        <ul>
            <li>Professionele installatie door gecertificeerde technici</li>
            <li>Inclusief alle benodigde materialen en aansluitingen</li>
            <li>Pre-installatie inspectie op locatie</li>
            <li>Installatie binnen 2-4 weken na acceptatie</li>
        </ul>

        <p style="margin-top: 10px;"><strong>Garantieverplichtingen</strong></p>
        <ul>
            <li>2 jaar volledige fabrieksgarantie op alle onderdelen</li>
            <li>5 jaar garantie op de installatie</li>
            <li>24/7 storingsdienst beschikbaar</li>
            <li>Jaarlijkse onderhoudsbeurt inbegrepen (eerste 2 jaar)</li>
        </ul>

        <p style="margin-top: 10px;"><strong>Levertijd en Planning</strong></p>
        <ul>
            <li>Levertijd: 2-4 weken na acceptatie offerte</li>
            <li>Installatieduur: 1-2 werkdagen</li>
            <li>Planning wordt in overleg met u bepaald</li>
            <li>Installatie op werkdagen tussen 08:00 - 17:00 uur</li>
        </ul>

        <p style="margin-top: 10px;"><strong>Algemene Voorwaarden</strong></p>
        <ul>
            <li><strong>Betalingsvoorwaarden:</strong> 30 dagen netto na factuurdatum. Bij opdrachten boven €10.000 wordt een aanbetaling van 30% gevraagd.</li>
            <li><strong>Offerte geldigheid:</strong> Deze offerte is 30 dagen geldig. Daarna behouden wij het recht voor om prijzen aan te passen.</li>
            <li><strong>Annulering:</strong> Annulering tot 7 dagen voor installatie is kosteloos. Latere annulering incurs administratiekosten.</li>
            <li><strong>Wijzigingen:</strong> Eventuele wijzigingen kunnen leiden tot prijsaanpassing en levertijdverlenging.</li>
        </ul>
    </div>

    <h2>Contactinformatie</h2>
    <div class="info-section">
        <p><strong>Sales Advisor:</strong> Lisa Bakker</p>
        <p><strong>Telefoon:</strong> +31 (0)6 12345678</p>
        <p><strong>E-mail:</strong> l.bakker@barroc.nl</p>
    </div>

    <div class="footer">
        <strong>Barroc Intens B.V.</strong><br>
        Terheijdenseweg 350, 4826 AA Breda<br>
        Tel: 076-5877400 | E-mail: info@barrocintens.nl | Web: www.barrocintens.nl<br>
        KvK: 12345678 | BTW: NL123456789B01<br>
        <br>
        <em>Dit document is vertrouwelijk en uitsluitend bestemd voor de geadresseerde. Ongeautoriseerd kopiëren, openbaarmaking of verspreiding is verboden.</em>
    </div>
</body>
</html>
