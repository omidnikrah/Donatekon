@extends('master')
@section('content')

    <body class="index">

    <header>@if (Auth::guest())
            <li><a href="{{ url('/auth/login') }}">Login</a></li>
            <li><a href="{{ url('/auth/register') }}">Register</a></li>
        @else
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                </ul>
            </li>
        @endif</header>

    <div class="container padding_index">
        <h3 class="titleh3">ویرایش دسته "{{ $category->title }}" </h3>
        <form class="form_cat" method="post" action="{{ action('CategoryController@update' , $category->id)  }}">
            <input type="hidden" name="_method" value="PATCH">
            <input type="hidden" value="{{ csrf_token() }}" name="_token">
            @if($errors->has())
                <span>{{ $errors->first('title') }}</span>
            @endif
            <input type="text" value="{{ $category->title }}" name="title" placeholder="عنوان دسته" >
            <input type="submit" value="ویرایش دسته">
        </form>
    </div>
    </body>

@stop