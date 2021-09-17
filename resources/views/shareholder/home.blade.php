@extends('shareholder.layouts.main_app')
@section('page-title')Добро пожаловать, в личный кабинет пайщика!@endsection
@section('page-content')
    <div class="row">
        @foreach ($posts as $post)
            <div class="col-12 pb-3">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="card-title mb-0 fon">{{ $post->title }}</h3>
                        <p class="mb-0">{{\Carbon\Carbon::parse($post->created_at)->locale('ru')->translatedFormat('M d, Y')}}г.</p>
                    </div>
                    <div class="card-body">
                        {!!$post->content!!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-auto">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
@section('custom-scripts')
    <script>
        $(document).ready(function() {
           $('.card blockquote').addClass('blockquote');
            $('.card img').addClass('img-fluid');
        });
    </script>
@endsection




