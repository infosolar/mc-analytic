@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('helpers.menu')
        <div class="col-10">
            @include('helpers.paginator', ['paginator' => $logs])
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col" style="text-align: center">Сообщение</th>
                    <th scope="col" style="text-align: center">Период обновления статистики</th>
                    <th scope="col" style="text-align: center">Смещение</th>
                    <th scope="col" style="text-align: center">Статус</th>
                    <th scope="col" style="text-align: center">Дата записи</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($logs as $log)
                    <tr>
                        <td style="text-align: center">{{ $log->message }}</td>
                        <td style="text-align: center">
                            {{ $log->sync_period_from->timezone('Europe/Kiev') }}
                            <br> - <br>
                            {{ $log->sync_period_to->timezone('Europe/Kiev') }}
                        </td>
                        <td style="text-align: center">{{ $log->sync_offset ?? '—' }}</td>
                        <td style="text-align: center">
                            @if($log->sync_status)
                                <span class="badge bg-success">Успех</span>
                            @else
                                <span class="badge bg-danger">Ошибка</span>
                            @endif
                        </td>
                        <td style="text-align: center">{{ $log->created_at->timezone('Europe/Kiev') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Нет данных</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
