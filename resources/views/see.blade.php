@extends('master')
@section('content')

    <body class="index">

    <div class="container padding_index">
        <h3 class="titleh3">چقدر دونیت کردی</h3>
        <form method="get"  class="form_cat" action="{{ action('DonateController@see') }}">
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="ایمیلت چی بود؟">
            <input type="submit" value="چک کن">
        </form>


        <ul class="listbox col-md-7">
            @if (isset($donates))
            @forelse($donates as $donate)

                <li>
                    <span>{{ $donate->price }} تومن </span>
                    <span> برای {{ $donate->category }}</span>
                    <span> در تاریخ {{  jDate::forge($donate->created_at)->format('%d %B %Y ')}}</span>
                </li>


@empty
                <span class="successup">شما که دونیتی نکردی تاحالا اصلا!!</span>
@endforelse
                @endif

        </ul>
    </div>
    </body>

@stop