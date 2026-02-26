@extends('africoders.help.layout')

@section('title', $title . ' - Africoders Help')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('help.home') }}">Help Center</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                    </ol>
                </nav>
            </div>

            <div class="card">
                <div class="card-header">
                    <h1 class="mb-1">{{ $title }}</h1>
                    <small class="text-muted">
                        @if($document->effective_date)
                            Effective: {{ \Carbon\Carbon::parse($document->effective_date)->format('F j, Y') }}
                        @else
                            Last updated: {{ $document->updated_at->format('F j, Y') }}
                        @endif
                        @if($document->version)
                            <br>Version {{ $document->version }}
                        @endif
                    </small>
                </div>
                <div class="card-body">
                    <div class="legal-document-content">
                        {!! $document->content !!}
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('help.home') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Back to Help Center
                </a>
            </div>
        </div>
    </div>
@endsection
