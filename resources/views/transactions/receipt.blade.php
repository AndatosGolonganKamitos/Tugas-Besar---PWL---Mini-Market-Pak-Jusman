<!DOCTYPE html>
<html>
<head>
    <title>Struk</title>

    <style>
        body{
            font-family: monospace;
            width: 300px;
            margin: auto;
            font-size: 12px;
        }

        .center{
            text-align:center;
        }

        hr{
            border:none;
            border-top:1px dashed #000;
        }

        table{
            width:100%;
            font-size:12px;
        }

        .right{
            text-align:right;
        }

        @media print{
            button{
                display:none;
            }
        }
    </style>
</head>
<body>

<div class="center">
    <h3>MINIMARKET</h3>
    <p>{{ $transaction->branch->name ?? 'Cabang Utama' }}</p>
</div>

<hr>

<p>No : {{ $transaction->invoice_number }}</p>
<p>{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
<p>Kasir : {{ $transaction->user->name ?? '-' }}</p>

<hr>

@foreach($transaction->items as $item)

<table>
    <tr>
        <td colspan="2">
            {{ $item->product->name }}
        </td>
    </tr>

    <tr>
        <td>
            {{ $item->qty }} x {{ number_format($item->price,0,',','.') }}
        </td>

        <td class="right">
            {{ number_format($item->subtotal,0,',','.') }}
        </td>
    </tr>
</table>

@endforeach

<hr>

<table>
    <tr>
        <td>TOTAL</td>
        <td class="right">
            Rp {{ number_format($transaction->total,0,',','.') }}
        </td>
    </tr>
</table>

<hr>

<div class="center">
    Terima Kasih<br>
    Selamat Berbelanja
</div>

<br>

<button onclick="window.print()">
    Cetak Struk
</button>

</body>
</html>