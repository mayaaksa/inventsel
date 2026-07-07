<table border="1" width="100%" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th>Peminjam</th>
            <th>Barang</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($borrowings as $b)
            @foreach($b->details as $detail)
            <tr>
                <td>{{ $b->borrower_name }}</td>
                <td>{{ $detail->product->name ?? 'Barang Terhapus' }}</td>
                <td>{{ $detail->jumlah }}</td>
            </tr>
            @endforeach
        @endforeach
    </tbody>
</table>