@extends('master')
@section('content')

    <body class="index">
    <header class="myheader">@if (Auth::guest())
            <li><a href="{{ url('/auth/login') }}">Login</a></li>
            <li><a href="{{ url('/auth/register') }}">Register</a></li>
        @else

                سلام
                <span>{{ Auth::user()->name }}</span>
                عزیز خوش آمدید

                    <a href="{{ url('/auth/logout') }}" id="fastexit">خروج سریع</a>

        @endif</header>
        <div class="container padding_index">
            <h3 class="titleh3">دسته بندی ها</h3>
            @if(Session::has('success'))
                <span class="successup">{{ Session::get('success') }}</span>
            @endif
            <ul class="listbox col-md-7">

                @foreach($cat as $cats)

                <li>
                    <span>{{ $cats->title }}</span>
                    <form method="post" action="{{ action('CategoryController@destroy' , $cats->id) }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input class="sss" type="submit"value="حذف">

                    </form>
                    <a href="{{ action('CategoryController@edit' , $cats->id) }}">ویرایش</a>
                </li>

            @endforeach
            </ul>
            <a href="{{ action('CategoryController@create')  }}" class="add">افزودن دسته جدید</a>
        </div>
    </body>

@stop