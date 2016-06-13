@extends('master')
@section('content')

    <body class="index">
    <div class="container padding_index">
        <h3 class="titleh3">افزودن دسته بندی  </h3>
        <form class="form_cat" method="post" action="{{ action('CategoryController@store')  }}">
            <input type="hidden" value="{{ csrf_token() }}" name="_token">
            @if($errors->has())
                <span>{{ $errors->first('title') }}</span>
            @endif
            <input type="text" value="{{ old('title') }}" name="title" placeholder="عنوان دسته" >
            <input type="submit" value="افزودن دسته">
        </form>
    </div>
    </body>

@stop