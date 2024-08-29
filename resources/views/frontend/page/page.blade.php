@extends('layouts.app')
@section('title', $page->name)
@section('content')
    <section class="contact-bg"><!--style="background-image: url('{{ $page->banner }}');"-->
        <div class="container">
            <div class="row justify-content-md-center align-items-center">
                <div class="col-12 col-md-11 col-lg-9 col-xl-8 col-xxl-7">
                    <h2 class="display-6">{{ $page->name }}</h2>
                </div>
            </div>
        </div>
    </section>
    <section class="min-height">
        <div class="container">
            <h4 class="text-center mt-4"></h4>
            {!! $page->description !!}
        </div>
    </section>
@endsection
