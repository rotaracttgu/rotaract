@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8"><h1>Mis Membresías</h1></div>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>Tipo</th>
                        <th>Monto</th>
                        <th>Período</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($membresias as $m)
                        <tr>
                            <td>{{ ucfirst($m->tipo_pago) }}</td>
                            <td>${{ number_format($m->monto, 2) }}</td>
                            <td>{{ $m->periodo_inicio->format('d/m') }} - {{ $m->periodo_fin->format('d/m/Y') }}</td>
                            <td><span class="badge badge-{{ $m->estado == 'activa' ? 'success' : 'secondary' }}">{{ ucfirst($m->estado) }}</span></td>
                            <td>-</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">No tienes membresías registradas</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
