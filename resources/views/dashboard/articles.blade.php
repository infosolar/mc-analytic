@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('helpers.menu')
        <div class="col-10">
            @include('helpers.paginator', ['paginator' => $articles])
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Страница</th>
                    <th scope="col">Просмотры</th>
                    <th scope="col">Статистика обновлена</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($articles as $article)
                    <tr>
                        <td>
                            <a href="https://mc.today{{ $article->url }}" target="_blank">
                                @if(empty($article->name))
                                    {{ $article->url }}
                                @else
                                    {{ $article->name }}
                                @endempty
                            </a>
                        </td>
                        <td>
                            {{ number_format($article->views, 0, '.', ' ') }}
                        </td>
                        <td>{{ $article->updated_at->timezone('Europe/Kiev') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Нет данных</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
