@extends('africoders.help.layout')

@section('title', ucwords(str_replace('-', ' ', $slug)) . ' - Africoders Help')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('help.home') }}">Help Center</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('help.articles') }}">Articles</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ucwords(str_replace('-', ' ', $slug)) }}</li>
                    </ol>
                </nav>
            </div>

            <div class="card">
                <div class="card-header">
                    <h1 class="mb-1">{{ ucwords(str_replace('-', ' ', $slug)) }}</h1>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Last updated: {{ date('F j, Y') }}</small>
                        <div>
                            <span class="badge bg-primary">{{ ucfirst($category) }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($slug === 'getting-started')
                        <div class="article-content">
                            <p class="lead">Welcome to Africoders! This guide will help you get started with our platform and make the most of all available services.</p>

                            <h3>What is Africoders?</h3>
                            <p>Africoders is a comprehensive platform designed to connect developers, creators, and technology enthusiasts across Africa. Our ecosystem includes:</p>
                            <ul>
                                <li><strong>Identity Service:</strong> Secure authentication and profile management</li>
                                <li><strong>Community Forums:</strong> Connect and collaborate with other developers</li>
                                <li><strong>Business Network:</strong> Professional networking and partnership opportunities</li>
                                <li><strong>Developer Resources:</strong> Tools, documentation, and learning materials</li>
                            </ul>

                            <h3>Creating Your Account</h3>
                            <p>To get started with Africoders:</p>
                            <ol>
                                <li>Visit <a href="https://{{ config('domains.africoders.id') }}/auth">our registration page</a></li>
                                <li>Fill in your basic information (name, email, password)</li>
                                <li>Verify your email address by clicking the link we send you</li>
                                <li>Complete your profile with additional details</li>
                            </ol>

                            <h3>Navigating the Platform</h3>
                            <p>Once you're logged in, you'll have access to:</p>
                            <ul>
                                <li><strong>Dashboard:</strong> Your personal overview and activity feed</li>
                                <li><strong>Profile:</strong> Manage your personal information and preferences</li>
                                <li><strong>Community:</strong> Participate in discussions and forums</li>
                                <li><strong>Business:</strong> Explore networking and partnership opportunities</li>
                            </ul>

                            <h3>Next Steps</h3>
                            <p>After setting up your account, consider:</p>
                            <ul>
                                <li>Completing your profile to help others find and connect with you</li>
                                <li>Exploring our community forums to find discussions of interest</li>
                                <li>Setting up your privacy preferences to control what information you share</li>
                                <li>Checking out our business networking features if you're looking for partnerships</li>
                            </ul>
                        </div>

                    @elseif($slug === 'account-security')
                        <div class="article-content">
                            <p class="lead">Keeping your Africoders account secure is important. Follow these best practices to protect your account and data.</p>

                            <h3>Strong Password Guidelines</h3>
                            <p>Your password is your first line of defense:</p>
                            <ul>
                                <li>Use at least 12 characters</li>
                                <li>Include uppercase and lowercase letters, numbers, and symbols</li>
                                <li>Don't use personal information like your name or birthday</li>
                                <li>Don't reuse passwords from other accounts</li>
                                <li>Consider using a password manager</li>
                            </ul>

                            <h3>Account Verification</h3>
                            <p>Keep your account verified:</p>
                            <ul>
                                <li>Verify your email address when you sign up</li>
                                <li>Keep your email address up to date</li>
                                <li>Respond to verification requests promptly</li>
                            </ul>

                            <h3>Recognizing Phishing Attempts</h3>
                            <p>Be aware of phishing attacks:</p>
                            <ul>
                                <li>We'll never ask for your password via email</li>
                                <li>Always check the URL before entering login information</li>
                                <li>Be suspicious of urgent requests for account information</li>
                                <li>When in doubt, contact our support team</li>
                            </ul>

                            <h3>What to Do If Your Account Is Compromised</h3>
                            <p>If you suspect your account has been compromised:</p>
                            <ol>
                                <li>Change your password immediately</li>
                                <li>Check your account activity for suspicious actions</li>
                                <li>Contact our support team right away</li>
                                <li>Update passwords on any other accounts that used the same password</li>
                            </ol>
                        </div>

                    @elseif($slug === 'privacy-settings')
                        <div class="article-content">
                            <p class="lead">Take control of your privacy on Africoders with our comprehensive privacy settings.</p>

                            <h3>Accessing Privacy Settings</h3>
                            <p>To access your privacy settings:</p>
                            <ol>
                                <li>Log into your Africoders account</li>
                                <li>Go to your <a href="https://{{ config('domains.africoders.id') }}/profile">Profile page</a></li>
                                <li>Click on "Privacy Settings" in the sidebar</li>
                            </ol>

                            <h3>Profile Visibility</h3>
                            <p>Control who can see your profile information:</p>
                            <ul>
                                <li><strong>Public:</strong> Anyone can see your basic profile</li>
                                <li><strong>Community Only:</strong> Only other Africoders members can see your profile</li>
                                <li><strong>Private:</strong> Only you can see your full profile</li>
                            </ul>

                            <h3>Communication Preferences</h3>
                            <p>Manage how we communicate with you:</p>
                            <ul>
                                <li>Email notifications for account activity</li>
                                <li>Community updates and newsletters</li>
                                <li>Marketing and promotional emails</li>
                                <li>SMS notifications (if enabled)</li>
                            </ul>

                            <h3>Data Sharing</h3>
                            <p>Control how your data is used:</p>
                            <ul>
                                <li>Analytics and usage data collection</li>
                                <li>Profile information sharing with partners</li>
                                <li>Activity data for personalized recommendations</li>
                            </ul>
                        </div>

                    @elseif($slug === 'business-guidelines')
                        <div class="article-content">
                            <p class="lead">Guidelines for creating and managing business listings on the Noccea Business platform.</p>

                            <h3>Business Listing Requirements</h3>
                            <p>To ensure quality and authenticity, all business listings must meet the following criteria:</p>
                            <ul>
                                <li><strong>Legitimate Business:</strong> Must be a real, operating business or service</li>
                                <li><strong>Accurate Information:</strong> All details (name, contact, location) must be current and correct</li>
                                <li><strong>Appropriate Category:</strong> Business must be listed in the correct category</li>
                                <li><strong>Professional Description:</strong> Clear, informative description of services/products</li>
                                <li><strong>Valid Contact Information:</strong> Working email, phone, or website</li>
                            </ul>

                            <h3>Content Guidelines</h3>
                            <p>Business descriptions and content should follow these standards:</p>
                            <ul>
                                <li><strong>Professional Language:</strong> Use clear, professional communication</li>
                                <li><strong>No Misleading Claims:</strong> Avoid exaggerated or false statements</li>
                                <li><strong>Appropriate Content:</strong> No offensive, discriminatory, or inappropriate material</li>
                                <li><strong>No Spam:</strong> Avoid repetitive keywords or promotional language</li>
                                <li><strong>Original Content:</strong> Use unique descriptions, not copied from other sources</li>
                            </ul>

                            <h3>Prohibited Activities</h3>
                            <p>The following activities are not permitted on the platform:</p>
                            <ul>
                                <li>Creating duplicate or fake business listings</li>
                                <li>Impersonating other businesses or individuals</li>
                                <li>Posting offensive, illegal, or inappropriate content</li>
                                <li>Spamming or excessive promotional activities</li>
                                <li>Manipulating reviews or ratings</li>
                                <li>Using the platform for illegal business activities</li>
                            </ul>

                            <h3>Review Process</h3>
                            <p>All business listings go through our review process:</p>
                            <ol>
                                <li><strong>Initial Review:</strong> Listings are reviewed within 1-2 business days</li>
                                <li><strong>Verification:</strong> We may contact you to verify business information</li>
                                <li><strong>Approval:</strong> Approved listings go live immediately</li>
                                <li><strong>Rejection:</strong> Rejected listings receive feedback for improvement</li>
                            </ol>

                            <h3>Maintaining Your Listing</h3>
                            <p>To keep your listing active and effective:</p>
                            <ul>
                                <li><strong>Keep Information Current:</strong> Update contact details, hours, and services regularly</li>
                                <li><strong>Respond to Inquiries:</strong> Be responsive to customer questions and feedback</li>
                                <li><strong>Monitor Reviews:</strong> Engage professionally with customer reviews</li>
                                <li><strong>Stay Active:</strong> Inactive listings may be archived after 6 months</li>
                            </ul>

                            <h3>Featured Listings</h3>
                            <p>Businesses may be selected for featured placement based on:</p>
                            <ul>
                                <li>Quality and completeness of listing information</li>
                                <li>Positive customer reviews and ratings</li>
                                <li>Active engagement with the platform</li>
                                <li>Community contribution and support</li>
                            </ul>

                            <h3>Violations and Enforcement</h3>
                            <p>Violations of these guidelines may result in:</p>
                            <ul>
                                <li><strong>Warning:</strong> First-time minor violations receive a warning</li>
                                <li><strong>Listing Suspension:</strong> Temporary removal while issues are addressed</li>
                                <li><strong>Account Suspension:</strong> Temporary account restrictions</li>
                                <li><strong>Permanent Removal:</strong> Severe or repeated violations result in permanent removal</li>
                            </ul>

                            <h3>Getting Help</h3>
                            <p>If you need assistance with your business listing:</p>
                            <ul>
                                <li>Visit our <a href="{{ route('help.faq') }}">FAQ section</a> for common questions</li>
                                <li><a href="{{ route('help.contact') }}">Contact our support team</a> for personalized help</li>
                                <li>Check your dashboard for listing status and feedback</li>
                                <li>Review our <a href="{{ route('help.article', 'getting-started') }}">getting started guide</a></li>
                            </ul>

                            <div class="alert alert-success">
                                <i class="bi bi-check-circle"></i>
                                <strong>Ready to Get Started?</strong>
                                <a href="https://business.noccea.test/businesses/create" class="alert-link">Create your business listing</a>
                                and join our growing directory of African businesses.
                            </div>
                        </div>

                    @else
                        <div class="article-content">
                            <p class="lead">This article is currently being developed. Please check back later for updated content.</p>

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                <strong>Article Coming Soon:</strong> We're working on creating comprehensive content for this topic.
                                In the meantime, feel free to <a href="{{ route('help.contact') }}" class="alert-link">contact our support team</a>
                                if you have specific questions about {{ str_replace('-', ' ', $slug) }}.
                            </div>

                            <h3>Related Resources</h3>
                            <ul>
                                <li><a href="{{ route('help.faq') }}">Frequently Asked Questions</a></li>
                                <li><a href="{{ route('help.contact') }}">Contact Support</a></li>
                                <li><a href="{{ route('help.articles') }}">Browse All Articles</a></li>
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="card-footer">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <small class="text-muted">Was this article helpful?</small>
                            <div class="btn-group ms-2" role="group">
                                <button type="button" class="btn btn-outline-success btn-sm" onclick="voteHelpful('{{ $slug }}')">
                                    <i class="bi bi-hand-thumbs-up"></i> Yes
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="voteUnhelpful('{{ $slug }}')">
                                    <i class="bi bi-hand-thumbs-down"></i> No
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <small class="text-muted">Views: <span id="view-count">{{ rand(150, 1500) }}</span></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Related Articles</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @if($slug !== 'getting-started')
                            <li><a href="{{ route('help.article', 'getting-started') }}">Getting Started with Africoders</a></li>
                        @endif
                        @if($slug !== 'account-security')
                            <li><a href="{{ route('help.article', 'account-security') }}">Account Security Best Practices</a></li>
                        @endif
                        @if($slug !== 'privacy-settings')
                            <li><a href="{{ route('help.article', 'privacy-settings') }}">Managing Your Privacy Settings</a></li>
                        @endif
                        <li><a href="{{ route('help.article', 'password-management') }}">Password Management</a></li>
                        <li><a href="{{ route('help.article', 'account-verification') }}">Account Verification</a></li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Need More Help?</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('help.faq') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-question-circle"></i> Check FAQs
                        </a>
                        <a href="{{ route('help.contact') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-envelope"></i> Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .article-content h3 {
        color: var(--color-primary);
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .article-content h3:first-child {
        margin-top: 0;
    }

    .article-content p, .article-content li {
        line-height: 1.6;
    }

    .article-content ul, .article-content ol {
        margin-bottom: 1.5rem;
    }

    .article-content a {
        color: var(--color-primary);
        text-decoration: none;
    }

    .article-content a:hover {
        text-decoration: underline;
    }
</style>
@endpush

@push('scripts')
<script>
function voteHelpful(slug) {
    // TODO: Implement helpful vote via AJAX
    alert('Thank you for your feedback!');
}

function voteUnhelpful(slug) {
    // TODO: Implement unhelpful vote via AJAX
    alert('Thank you for your feedback! We\'ll work on improving this article.');
}
</script>
@endpush


