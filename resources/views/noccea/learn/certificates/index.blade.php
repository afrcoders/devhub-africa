@extends('noccea.learn.layout')

@section('title', 'My Certificates - Learn Noccea')

@section('content')
<div class="bg-white">
    <!-- Header -->
    <div class="relative h-64 bg-gradient-to-br from-purple-500 to-indigo-600 overflow-hidden">
        <div class="absolute inset-0 flex items-end">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-8">
                <h1 class="text-4xl font-bold text-white mb-2">My Certificates</h1>
                <p class="text-white text-lg">Showcase your achievements and learning progress</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @auth
            @if($certificates && count($certificates) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($certificates as $cert)
                    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-lg shadow-lg p-8 hover:shadow-xl transition relative overflow-hidden">
                        <!-- Certificate Border -->
                        <div class="absolute inset-0 border-8 border-double border-yellow-400 m-4 pointer-events-none"></div>

                        <!-- Content -->
                        <div class="relative z-10 text-center">
                            <!-- Badge -->
                            <div class="mb-6 flex justify-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-white shadow-lg">
                                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                            </div>

                            <!-- Text -->
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Certificate of Completion</h3>
                            <p class="text-gray-700 font-semibold mb-4">{{ $cert->course->title }}</p>

                            <div class="mb-6 py-4 border-t border-b border-yellow-300">
                                <p class="text-sm text-gray-600 mb-1">Certificate Number</p>
                                <p class="font-mono text-sm font-bold text-gray-900">{{ $cert->certificate_code }}</p>
                            </div>

                            <p class="text-sm text-gray-600 mb-6">
                                Issued on {{ $cert->issued_at->format('F j, Y') }}
                            </p>

                            <!-- Actions -->
                            <div class="flex gap-3">
                                <button onclick="downloadCertificate('{{ $cert->certificate_code }}')" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm">
                                    Download PDF
                                </button>
                                <button onclick="shareCertificate('{{ $cert->certificate_code }}', '{{ $cert->course->title }}')" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium text-sm">
                                    Share
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Stats -->
                <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-6 text-center">
                        <p class="text-3xl font-bold text-blue-600 mb-2">{{ count($certificates) }}</p>
                        <p class="text-gray-700 font-semibold">Certificates Earned</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg p-6 text-center">
                        <p class="text-3xl font-bold text-green-600 mb-2">100%</p>
                        <p class="text-gray-700 font-semibold">Completion Rate</p>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg p-6 text-center">
                        <p class="text-3xl font-bold text-purple-600 mb-2">{{ count($certificates) * 20 }}</p>
                        <p class="text-gray-700 font-semibold">Points Earned</p>
                    </div>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="mb-6">
                        <svg class="w-24 h-24 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 0 0 9.5 3H4v10a1 1 0 001 1h5.5A2.5 2.5 0 0 0 12 11.5zm0 0h5.5A2.5 2.5 0 0 1 20 14v5a1 1 0 01-1 1h-9a1 1 0 01-1-1v-5a2.5 2.5 0 012.5-2.5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">No Certificates Yet</h3>
                    <p class="text-gray-600 mb-6">Complete courses to earn certificates and showcase your learning achievements</p>
                    <a href="{{ route('noccea.learn.courses.index') }}" class="inline-block px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-semibold">
                        Browse Courses
                    </a>
                </div>
            @endif
        @else
            <div class="text-center py-16">
                <div class="mb-6">
                    <svg class="w-24 h-24 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Sign In Required</h3>
                <p class="text-gray-600 mb-6">Sign in to your account to view your certificates</p>
                <a href="{{ route('noccea.learn.login') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                    Sign In
                </a>
            </div>
        @endauth
    </div>
</div>

<script>
function downloadCertificate(code) {
    alert('Certificate download: ' + code);
    // TODO: Implement PDF generation and download
}

function shareCertificate(code, courseTitle) {
    const text = `I just completed "${courseTitle}" on Noccea Learn! 🎓 Certificate: ${code}`;
    const url = window.location.href;

    // Share options
    if (navigator.share) {
        navigator.share({
            title: 'Certificate Earned',
            text: text,
            url: url
        });
    } else {
        // Fallback to social media links
        const encodedText = encodeURIComponent(text);
        const encodedUrl = encodeURIComponent(url);

        const options = {
            'twitter': `https://twitter.com/intent/tweet?text=${encodedText}&url=${encodedUrl}`,
            'facebook': `https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}`,
            'linkedin': `https://www.linkedin.com/sharing/share-offsite/?url=${encodedUrl}`
        };

        console.log('Share options available. Implement social sharing UI.');
    }
}
</script>
@endsection
