<!DOCTYPE html>
<html>
<head>
    <title>Audit Pemenuhan AKG</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .header { text-align: center; margin-bottom: 30px; }
        h2 { margin: 0; color: #071e49; }
    </style>
</head>
<body>
    <div class="header">
        <h2>BADAN GIZI NASIONAL</h2>
        <p>LAPORAN AUDIT PEMENUHAN ANGKA KECUKUPAN GIZI (AKG)</p>
        <hr>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Distribusi</th>
                <th>Waktu Penilaian</th>
                <th>Satuan Pelayanan</th>
                <th class="text-center">Kalori (Kkal)</th>
                <th class="text-center">Protein (g)</th>
                <th class="text-center">Karbohidrat (g)</th>
                <th class="text-center">Status Audit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nutritions as $nutrition)
            <tr>
                <td>#{{ $nutrition->delivery_id }}</td>
                <td>{{ \Carbon\Carbon::parse($nutrition->created_at)->format('d/m/Y H:i') }}</td>
                <td>{{ $nutrition->delivery->sppg->name ?? 'N/A' }}</td>
                <td class="text-center">{{ $nutrition->calories }}</td>
                <td class="text-center">{{ $nutrition->protein_g }}</td>
                <td class="text-center">{{ $nutrition->karbo_g }}</td>
                <td class="text-center"><strong>MEMENUHI STANDAR</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
