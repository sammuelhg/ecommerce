@extends('emails.layouts.global')

@section('content')
    <div style="font-family: 'Segoe UI', Arial, sans-serif; color: #333333; line-height: 1.6;">
        {!! $content !!}
    </div>

    <!-- Tracking Pixel -->
    <img src="{{ $trackingUrl }}" width="1" height="1" style="display:none;" alt="" />
@endsection
