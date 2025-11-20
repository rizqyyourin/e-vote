@extends('layouts.app')

@section('title', '')

@section('content')
<div class="space-y-20">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-sky-50 via-white to-blue-50 rounded-2xl overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-sky-100 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        
        <div class="relative grid md:grid-cols-2 gap-12 items-center px-8 md:px-12 py-16 md:py-24">
            <!-- Content Left -->
            <div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                    Vote with <span class="bg-gradient-to-r from-sky-600 to-blue-600 bg-clip-text text-transparent">Ease, Trust,</span> and <span class="bg-gradient-to-r from-sky-600 to-blue-600 bg-clip-text text-transparent">Transparency</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-600 mb-10 leading-relaxed">
                    A simple, secure, and trustworthy e-voting website for your organization. Manage voting with ease and see results in real-time.
                </p>
                
                @auth
                <div class="flex flex-col sm:flex-row gap-4">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="inline-block bg-gradient-to-r from-sky-600 to-sky-700 text-white px-8 py-3 rounded-lg font-semibold hover:shadow-lg hover:scale-105 transition-all duration-200">
                            Admin Dashboard
                        </a>
                    @else
                        <a href="{{ route('voter.dashboard') }}" class="inline-block bg-gradient-to-r from-sky-600 to-sky-700 text-white px-8 py-3 rounded-lg font-semibold hover:shadow-lg hover:scale-105 transition-all duration-200">
                            My Votes
                        </a>
                    @endif
                </div>
            @else
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('login') }}" class="inline-block text-center border-2 border-sky-600 text-sky-600 px-8 py-3 rounded-lg font-semibold hover:bg-sky-50 hover:scale-105 transition-all duration-200 w-full sm:w-auto">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="inline-block text-center bg-gradient-to-r from-sky-600 to-sky-700 text-white px-8 py-3 rounded-lg font-semibold hover:shadow-lg hover:scale-105 transition-all duration-200 w-full sm:w-auto">
                        Create Account
                    </a>
                </div>
            @endauth
            </div>
            
            <!-- Illustration Right -->
            <div class="hidden md:flex items-center justify-center">
                <div class="w-80 h-80 lg:w-96 lg:h-96 bg-white rounded-3xl shadow-2xl flex items-center justify-center overflow-hidden p-6">
                    <img src="https://media.lordicon.com/icons/wired/flat/1933-vote-elections.gif" alt="E-Voting Animation" class="w-full h-full object-contain">
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="px-8 md:px-0">
        <h2 class="text-4xl font-bold text-center mb-16 text-gray-900">Key Features</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="group relative bg-white p-8 rounded-xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-sky-200 transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-br from-sky-50 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <div class="w-14 h-14 bg-gradient-to-br from-sky-100 to-sky-50 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Easy to Use</h3>
                    <p class="text-gray-600 leading-relaxed">A simple and intuitive interface that makes voting quick and effortless, requiring no special training.</p>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="group relative bg-white p-8 rounded-xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-sky-200 transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-br from-sky-50 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <div class="w-14 h-14 bg-gradient-to-br from-sky-100 to-sky-50 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Secure & Trustworthy</h3>
                    <p class="text-gray-600 leading-relaxed">Each voter can only cast one vote. Data is encrypted with multi-layer security systems.</p>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="group relative bg-white p-8 rounded-xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-sky-200 transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-br from-sky-50 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative">
                    <div class="w-14 h-14 bg-gradient-to-br from-sky-100 to-sky-50 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Transparent & Real-time</h3>
                    <p class="text-gray-600 leading-relaxed">View voting results in real-time with detailed reports and a complete audit trail at any time.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- How it works -->
    
    <!-- How it works -->
    <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl p-12 md:p-16">
        <h2 class="text-4xl font-bold text-center mb-16 text-gray-900">How It Works</h2>
        
        <div class="relative">
            <!-- Connecting line -->
            <div class="hidden md:block absolute top-8 left-0 right-0 h-1 bg-gradient-to-r from-sky-200 via-sky-400 to-sky-200"></div>
            
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="relative flex flex-col items-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-sky-600 to-sky-700 text-white rounded-full flex items-center justify-center mb-8 font-bold text-xl shadow-lg relative z-10">
                        1
                    </div>
                    <div class="text-center">
                        <h4 class="font-bold text-lg text-gray-900 mb-3">Admin Creates</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Admin creates a new vote with candidate list and sets voting time.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="relative flex flex-col items-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-sky-600 to-sky-700 text-white rounded-full flex items-center justify-center mb-8 font-bold text-xl shadow-lg relative z-10">
                        2
                    </div>
                    <div class="text-center">
                        <h4 class="font-bold text-lg text-gray-900 mb-3">Share Link</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Share the voting link with all eligible voters.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="relative flex flex-col items-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-sky-600 to-sky-700 text-white rounded-full flex items-center justify-center mb-8 font-bold text-xl shadow-lg relative z-10">
                        3
                    </div>
                    <div class="text-center">
                        <h4 class="font-bold text-lg text-gray-900 mb-3">Voter Votes</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">Voters login and cast one vote for their choice.</p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="relative flex flex-col items-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-sky-600 to-sky-700 text-white rounded-full flex items-center justify-center mb-8 font-bold text-xl shadow-lg relative z-10">
                        4
                    </div>
                    <div class="text-center">
                        <h4 class="font-bold text-lg text-gray-900 mb-3">View Results</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">View real-time voting results and export reports to PDF.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="mx-auto bg-gradient-to-r from-sky-600 to-sky-700 rounded-2xl p-12 md:p-16 text-center text-white overflow-hidden relative">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full -ml-32 -mb-32"></div>
        
        <div class="relative">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Get Started?</h2>
            <p class="text-lg md:text-xl text-sky-100 mb-10 max-w-2xl mx-auto">Create your first vote now and experience the ease of digital democracy.</p>
            
            @auth
                @if(!auth()->user()->isAdmin())
                    <a href="{{ route('voter.dashboard') }}" class="inline-block bg-white text-sky-600 px-8 py-3 rounded-lg font-semibold hover:bg-sky-50 hover:scale-105 transition-all duration-200 shadow-lg">
                        View Available Votes
                    </a>
                @else
                    <a href="{{ route('admin.dashboard') }}" class="inline-block bg-white text-sky-600 px-8 py-3 rounded-lg font-semibold hover:bg-sky-50 hover:scale-105 transition-all duration-200 shadow-lg">
                        Create New Vote
                    </a>
                @endif
            @else
                <a href="{{ route('register') }}" class="inline-block bg-white text-sky-600 px-8 py-3 rounded-lg font-semibold hover:bg-sky-50 hover:scale-105 transition-all duration-200 shadow-lg">
                    Sign Up Now - Free!
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
