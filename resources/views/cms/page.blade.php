@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description)

@section('content')
<div class="cms-page">
    {!! $renderedContent !!}
</div>
@endsection
