<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Catálogo de Productos - B&R Tecnología</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0d9488;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #0d9488;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0 0;
            font-size: 12px;
        }
        .info {
            margin-bottom: 20px;
            font-size: 11px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #0d9488;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #e9ecef;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .summary {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .summary h3 {
            margin: 0 0 10px;
            color: #0d9488;
            font-size: 14px;
        }
        .summary-item {
            display: inline-block;
            margin-right: 30px;
            font-size: 11px;
        }
        .summary-item strong {
            color: #333;
        }
        .price {
            font-weight: bold;
            color: #0d9488;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>B&R Tecnología</h1>
        <p>Catálogo de Productos</p>
    </div>

    <div class="info">
        <strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i:s') }}
    </div>

    <div class="summary">
        <h3>Resumen</h3>
        <div class="summary-item">
            <strong>Total de productos:</strong> {{ $products->count() }}
        </div>
        <div class="summary-item">
            <strong>Productos activos:</strong> {{ $products->where('is_active', true)->count() }}
        </div>
        <div class="summary-item">
            <strong>Categorías:</strong> {{ $products->pluck('category.name')->unique()->filter()->count() }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%">SKU</th>
                <th style="width: 25%">Nombre</th>
                <th style="width: 15%">Categoría</th>
                <th style="width: 12%" class="text-right">Precio</th>
                <th style="width: 10%" class="text-center">Stock</th>
                <th style="width: 10%" class="text-center">Estado</th>
                <th style="width: 20%">Creado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->sku_code }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category?->name ?? 'Sin categoría' }}</td>
                <td class="text-right price">${{ number_format($product->price_base, 2) }}</td>
                <td class="text-center">
                    @if($product->stock_available > 10)
                        <span class="badge badge-success">{{ $product->stock_available }}</span>
                    @elseif($product->stock_available > 0)
                        <span class="badge badge-warning">{{ $product->stock_available }}</span>
                    @else
                        <span class="badge badge-danger">0</span>
                    @endif
                </td>
                <td class="text-center">
                    @if($product->is_active)
                        <span class="badge badge-success">Activo</span>
                    @else
                        <span class="badge badge-danger">Inactivo</span>
                    @endif
                </td>
                <td>{{ $product->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>© {{ date('Y') }} B&R Tecnología - Machala, Ecuador</p>
        <p>Este documento fue generado automáticamente desde el sistema de catálogo.</p>
    </div>
</body>
</html>
