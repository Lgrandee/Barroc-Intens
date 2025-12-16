<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contract PDF</title>
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
        <div class="cover-title">SERVICE CONTRACT</div>
        <div class="cover-subtitle">{{ date('Y', strtotime($contract->start_date)) }} – {{ date('Y', strtotime($contract->end_date)) }}</div>
        
        <div class="cover-info">
            <div class="cover-info-item">
                <span class="cover-info-label">Customer:</span> {{ $contract->customer->name_company ?? 'Unknown' }}
            </div>
            <div class="cover-info-item">
                <span class="cover-info-label">Contract Number:</span> CON-{{ date('Y', strtotime($contract->start_date)) }}-{{ str_pad($contract->id, 3, '0', STR_PAD_LEFT) }}
            </div>
            <div class="cover-info-item">
                <span class="cover-info-label">Period:</span> {{ \Carbon\Carbon::parse($contract->start_date)->format('d M Y') }} – {{ \Carbon\Carbon::parse($contract->end_date)->format('d M Y') }}
            </div>
            <div class="cover-info-item">
                <span class="cover-info-label">Status:</span> <strong>{{ ucfirst($contract->status) }}</strong>
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
                service@barroc.nl<br>
                +31 (0)20 123 4567
            </div>
        </div>
    </div>

    <h1>Contract #CON-{{ date('Y', strtotime($contract->start_date)) }}-{{ str_pad($contract->id, 3, '0', STR_PAD_LEFT) }}</h1>

    <h2>Contract Information</h2>
    <div class="info-grid">
        <div class="info-item">
            <span class="info-label">Customer</span>
            <span class="info-value">{{ $contract->customer->name_company ?? 'Unknown' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Contact Person</span>
            <span class="info-value">{{ $contract->customer->contact_person ?? 'N/A' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Start Date</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($contract->start_date)->format('d F Y') }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">End Date</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($contract->end_date)->format('d F Y') }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Status</span>
            <span class="info-value"><strong>{{ ucfirst($contract->status) }}</strong></span>
        </div>
        <div class="info-item">
            <span class="info-label">Location</span>
            <span class="info-value">{{ $contract->customer->city ?? 'Unknown' }}, {{ $contract->customer->country ?? 'Netherlands' }}</span>
        </div>
    </div>

    <h2>Products & Services</h2>
    <table>
        <thead>
            <tr>
                <th>Product / Service</th>
                <th style="width: 15%; text-align: center;">Quantity</th>
                <th style="width: 20%; text-align: right;">Price per Unit</th>
            </tr>
        </thead>
        <tbody>
        @foreach($contract->products as $product)
            <tr>
                <td>{{ $product->product_name }}</td>
                <td style="text-align: center;">{{ $product->pivot->quantity ?? 1 }}</td>
                <td style="text-align: right;">€{{ number_format($product->price, 2, ',', '.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>Terms & Conditions</h2>
    <div class="terms-box">
        <p><strong>Contract Scope</strong></p>
        <p>This contract includes standard maintenance services, parts, and annual inspection. Additional work beyond this scope will be charged separately at our standard service rates.</p>
        <ul>
            <li><strong>Delivery time/response:</strong> 48 hours</li>
            <li><strong>Warranty:</strong> 2 years on performed work</li>
            <li><strong>Payment terms:</strong> Annual invoice, due within 30 days</li>
            <li><strong>Cancellation:</strong> 1 month notice period required</li>
        </ul>
    </div>

    <h2>Maintenance Support Policy</h2>
    <div class="terms-box">
        <p><strong>Monthly Free Maintenance Included</strong></p>
        <p>As a valued customer, your contract includes <strong>one free maintenance visit per month</strong>. This covers routine maintenance, inspections, and minor adjustments.</p>
        <p><strong>Additional Maintenance & Charges:</strong></p>
        <ul>
            <li>Additional visits beyond the monthly free visit will incur standard service charges</li>
            <li>Issues caused by manufacturing defects from Barroc Intens are always covered at no cost</li>
            <li>Emergency support and after-hours service may carry premium rates</li>
        </ul>
        <p><strong>How to Request Service:</strong></p>
        <ul>
            <li>Email: <strong>service@barroc.nl</strong></li>
            <li>Phone: <strong>+31 (0)20 123 4567</strong></li>
            <li>Response time: Within 48 business hours</li>
        </ul>
    </div>

    <h2>Billing & Payment Schedule</h2>
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Due Date</th>
                <th style="width: 20%; text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Annual service & maintenance contract {{ date('Y', strtotime($contract->start_date)) }}</td>
                <td>{{ \Carbon\Carbon::parse($contract->start_date)->format('d M Y') }}</td>
                <td style="text-align: right;"><strong>€{{ number_format($contract->products->sum('price') ?: ($contract->product->price ?? 1250), 2, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td>Interim inspection & service</td>
                <td>{{ \Carbon\Carbon::parse($contract->start_date)->addMonths(6)->format('d M Y') }}</td>
                <td style="text-align: right;"><em>Included</em></td>
            </tr>
        </tbody>
    </table>

    <div class="info-section">
        <p><strong>Payment Instructions:</strong> Please remit payment to the account details provided on your invoice. Payment must be received within 30 days from the invoice date. For questions about your billing, please contact our Finance department.</p>
    </div>

    <div class="footer">
        <strong>Barroc Intens B.V.</strong> — Professional Service & Maintenance Solutions<br>
        <strong>Email:</strong> service@barroc.nl  |  <strong>Phone:</strong> +31 (0)20 123 4567<br>
        <strong>Document:</strong> CON-{{ date('Y', strtotime($contract->start_date)) }}-{{ str_pad($contract->id, 3, '0', STR_PAD_LEFT) }}  |  <strong>Generated:</strong> {{ now()->format('d F Y H:i') }}<br>
        <br>
        <em>This document is confidential and intended for the addressee only. Unauthorized copying, disclosure, or distribution is prohibited.</em>
    </div>
</body>
</html>
