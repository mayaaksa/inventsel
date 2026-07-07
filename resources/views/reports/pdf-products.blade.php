<h2 style="text-align: center;">Data Barang InvenTsel</h2>
<table border="1" width="100%" style="border-collapse: collapse; margin-top: 20px;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Stok</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $p)
        <tr>
            <td style="padding: 8px;">{{ $p->kode_barang }}</td>
            <td style="padding: 8px;">{{ $p->name }}</td>
            <td style="padding: 8px; text-align: center;">{{ $p->stok }}</td>
        </tr>
        @endforeach
    </tbody>
</table>