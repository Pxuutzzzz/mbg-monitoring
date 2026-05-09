<!DOCTYPE html>
<html>
<head>
    <title>Rekapitulasi Keuangan MBG</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .header { text-align: center; margin-bottom: 30px; }
        h2 { margin: 0; color: #071e49; }
    </style>
</head>
<body>
    <div class="header">
        <h2>BADAN GIZI NASIONAL</h2>
        <p>REKAPITULASI PENGGUNAAN ANGGARAN SPPG</p>
        <hr>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Satuan Pelayanan</th>
                <th class="text-right">Bahan Baku</th>
                <th class="text-right">Transport</th>
                <th class="text-right">Operasional</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
            <tr>
                <td>{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td>
                <td>{{ $record->sppg->name }}</td>
                <td class="text-right">Rp {{ number_format($record->bahan_cost) }}</td>
                <td class="text-right">Rp {{ number_format($record->transport_cost) }}</td>
                <td class="text-right">Rp {{ number_format($record->total - $record->bahan_cost - $record->transport_cost) }}</td>
                <td class="text-right"><strong>Rp {{ number_format($record->total) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
