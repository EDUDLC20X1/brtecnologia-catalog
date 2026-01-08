<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de Solicitudes - B&R Tecnología</title>
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
            padding: 10px 6px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
        }
        td {
            padding: 8px 6px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
            font-size: 9px;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-contacted {
            background-color: #cce5ff;
            color: #004085;
        }
        .badge-completed {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-rejected {
            background-color: #f8d7da;
            color: #721c24;
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
        .summary-grid {
            display: table;
            width: 100%;
        }
        .summary-item {
            display: table-cell;
            text-align: center;
            padding: 5px;
        }
        .summary-item .number {
            font-size: 18px;
            font-weight: bold;
            color: #0d9488;
        }
        .summary-item .label {
            font-size: 10px;
            color: #666;
        }
        .message-cell {
            max-width: 150px;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>B&R Tecnología</h1>
        <p>Reporte de Solicitudes de Información</p>
    </div>

    <div class="info">
        <strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i:s') }}
    </div>

    <div class="summary">
        <h3>Resumen de Solicitudes</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="number">{{ $requests->count() }}</div>
                <div class="label">Total</div>
            </div>
            <div class="summary-item">
                <div class="number">{{ $requests->where('status', 'pending')->count() }}</div>
                <div class="label">Pendientes</div>
            </div>
            <div class="summary-item">
                <div class="number">{{ $requests->where('status', 'contacted')->count() }}</div>
                <div class="label">Contactados</div>
            </div>
            <div class="summary-item">
                <div class="number">{{ $requests->where('status', 'completed')->count() }}</div>
                <div class="label">Completados</div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">ID</th>
                <th style="width: 12%">Fecha</th>
                <th style="width: 15%">Nombre</th>
                <th style="width: 18%">Email</th>
                <th style="width: 10%">Teléfono</th>
                <th style="width: 15%">Producto</th>
                <th style="width: 15%">Mensaje</th>
                <th style="width: 10%">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
            <tr>
                <td>{{ $request->id }}</td>
                <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $request->name }}</td>
                <td>{{ $request->email }}</td>
                <td>{{ $request->phone ?? 'N/A' }}</td>
                <td>{{ $request->product?->name ?? 'N/A' }}</td>
                <td class="message-cell">{{ Str::limit($request->message, 50) }}</td>
                <td>
                    @switch($request->status)
                        @case('pending')
                            <span class="badge badge-pending">Pendiente</span>
                            @break
                        @case('contacted')
                            <span class="badge badge-contacted">Contactado</span>
                            @break
                        @case('completed')
                            <span class="badge badge-completed">Completado</span>
                            @break
                        @case('rejected')
                            <span class="badge badge-rejected">Rechazado</span>
                            @break
                        @default
                            <span class="badge">{{ $request->status }}</span>
                    @endswitch
                </td>
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
