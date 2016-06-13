@extends('master')
@section('content')

    <body class="bg_donate">
    <div class="container padding_index">
        <h1 id="smile">خیلی خوشحالم که میخوای دونیت کنی</h1>
        <form method="post" action="{{ action('DonateController@payment') }}" id="formDonate" class="col-md-6">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @if($errors->has())
                <span class="errors">{{ $errors->first('name') }}</span>
            @endif
            <input type="text" name="name" value="{{ old('name') }}" placeholder="اسم و فامیلت؟">
            @if($errors->has())
                <span class="errors">{{ $errors->first('email') }}</span>
            @endif
            <input type="email" name="email" value="{{ old('email') }}" placeholder="ایمیلت؟">
            @if($errors->has())
                <span class="errors">{{ $errors->first('price') }}</span>
            @endif
            <input type="text" name="price" value="{{ old('price') }}" placeholder="چقدر میخوای دونیت کنی؟">
            <span class="between">با پول چیکار کنم؟</span>
            @if($errors->has())
                <span class="errors">{{ $errors->first('price') }}</span>
            @endif
            <select name="category">
                @foreach($cat as $cats => $id)
                    <option value=" {{ $id }}">{{ $id }}</option>
                @endforeach
            </select>
            <input type="submit" value="تموم">
        </form>
    </div>
    </body>

@stop
