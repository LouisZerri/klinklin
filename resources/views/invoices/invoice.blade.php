<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture Klinklin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 30px;
            color: #333;
            line-height: 1.4;
        }

        .invoice-header {
            margin-bottom: 40px;
        }

        .invoice-number {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .invoice-date {
            font-size: 14px;
            color: #666;
        }

        .parties-container {
            display: flex;
            justify-content: space-between;
            margin: 40px 0;
            gap: 40px;
        }

        .party-section {
            flex: 1;
        }

        .party-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .party-info {
            font-size: 11px;
        }

        .info-line {
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .party-info .label {
            color: #666;
            font-weight: normal;
            display: inline-block;
            width: 140px;
            vertical-align: top;
        }

        .party-info .value {
            color: #333;
            display: inline-block;
        }

        .detail-section {
            margin: 40px 0;
        }

        .detail-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .invoice-table thead {
            background-color: #666;
        }

        .invoice-table th {
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }

        .invoice-table th.text-center {
            text-align: center;
        }

        .invoice-table th.text-right {
            text-align: right;
        }

        .invoice-table td {
            padding: 12px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }

        .invoice-table td.text-center {
            text-align: center;
        }

        .invoice-table td.text-right {
            text-align: right;
        }

        .invoice-table tbody tr:hover {
            background-color: #f9f9f9;
        }

        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .totals-box {
            width: 300px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            font-size: 11px;
        }

        .totals-row.total {
            font-weight: bold;
            font-size: 12px;
            border-top: 1px solid #333;
            padding-top: 8px;
            margin-top: 5px;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="invoice-header">
        <div class="invoice-number">Facture {{ $order->order_number }}</div>
        <div class="invoice-date">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
    </div>

    <div class="parties-container">
        <div class="party-section">
            <div class="party-title">Émetteur</div>
            <div class="party-info">
                <div class="info-line">
                    <span class="label">Société :</span>
                    <span class="value">Klinklin</span>
                </div>
                <div class="info-line">
                    <span class="label">Contact :</span>
                    <span class="value">John Doe</span>
                </div>

                <div class="info-line">
                    <span class="label">Adresse :</span>
                    <span class="value">10 avenue la république</br>75008 Paris</span>
                </div>

                <div class="info-line">
                    <span class="label">Pays :</span>
                    <span class="value">France</span>
                </div>

                <div class="info-line">
                    <span class="label">Numéro d'entreprise :</span>
                    <span class="value">12345678901234</span>
                </div>

                <div class="info-line">
                    <span class="label">Numéro de téléphone :</span>
                    <span class="value">0678941058</span>
                </div>

                <div class="info-line">
                    <span class="label">Adresse email :</span>
                    <span class="value">contact@klinklin.com</span>
                </div>
            </div>
        </div>

        <div class="party-section">
            <div class="party-title">Destinataire</div>
            <div class="party-info">
                <div class="info-line">
                    <span class="label">Nom et prénom :</span>
                    <span class="value">{{ $order->user->firstname }} {{ $order->user->lastname }}</span>
                </div>
                <div class="info-line">
                    <span class="label">Adresse :</span>
                    <span class="value">{{ $order->address }}<br>{{ $order->zip_code }} {{ $order->city }}</span>
                </div>
                <div class="info-line">
                    <span class="label">Pays :</span>
                    <span class="value">France</span>
                </div>
                <div class="info-line">
                    <span class="label">Numéro de téléphone :</span>
                    <span class="value">{{ $order->user->phone }}</span>
                </div>
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-title">Détail</div>

            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Description</th>
                        <th class="text-right">Prix unitaire HT</th>
                        <th class="text-center">Quantité</th>
                        <th class="text-right">Total HT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->article->type }}</td>
                            <td>{{ $item->article->name }}</td>
                            <td class="text-right">{{ number_format($item->article->unit_price, 2, ',', ' ') }} €
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-right">
                                {{ number_format($item->quantity * $item->article->unit_price, 2, ',', ' ') }} €
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="totals-section">
                <div class="totals-box">
                    <div class="totals-row">
                        <span><b>Sous-total HT : </b></span>
                        <span>{{ number_format($order->subtotal, 2, ',', ' ') }} €</span>
                    </div>
                    <div class="totals-row">
                        <span><b>Frais d'expédition : </b></span>
                        <span>10,00 €</span>
                    </div>
                    <div class="totals-row">
                        <span><b>Taxe (5%) : </b></span>
                        <span>5,00 €</span>
                    </div>
                    <div class="totals-row total">
                        <span>Total TTC : </span>
                        <span>{{ number_format($total, 2, ',', ' ') }} €</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            Merci pour votre confiance.
        </div>
</body>

</html>
