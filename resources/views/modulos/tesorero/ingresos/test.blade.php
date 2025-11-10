@extends('layouts.app')

@section('content')
<div class="container">
    <h1>PRUEBA - Listado de Ingresos</h1>
    <p>Si ves esto, la vista funciona correctamente.</p>
    
    @if(isset($ingresos))
        <p>Hay {{ $ingresos->count() }} ingresos en la base de datos.</p>
    @else
        <p>No se pasaron ingresos al controlador.</p>
    @endif
</div>
@endsection
