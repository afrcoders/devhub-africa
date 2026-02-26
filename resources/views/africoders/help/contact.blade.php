@extends('africoders.help.layout')

@section('title', 'Contact Us - Africoders Help')

@section('content')
    <div class="section-header text-center">
        <h1>Get in Touch</h1>
        <p>We're here to help. Send us a message and we'll get back to you as soon as possible.</p>
    </div>

    <div class="row">
        <!-- Contact Form -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Send us a Message</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-circle"></i> Please fix the errors below:
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('help.contact.submit') }}" id="contactForm" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Message Type *</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">-- Select a type --</option>
                                <option value="support" {{ old('type') == 'support' ? 'selected' : '' }}>Support Request</option>
                                <option value="business" {{ old('type') == 'business' ? 'selected' : '' }}>Business Inquiry</option>
                                <option value="legal" {{ old('type') == 'legal' ? 'selected' : '' }}>Legal Matter</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject *</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                   id="subject" name="subject" value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message *</label>
                            <textarea class="form-control @error('message') is-invalid @enderror"
                                      id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                            <small class="form-text text-muted">Please provide as much detail as possible about your inquiry.</small>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input @error('recaptcha') is-invalid @enderror"
                                       type="checkbox" id="recaptcha" name="recaptcha" value="1" required>
                                <label class="form-check-label" for="recaptcha">
                                    I'm not a robot *
                                </label>
                                @error('recaptcha')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">Please confirm you are human by checking this box.</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="submitBtn" disabled>
                            <i class="bi bi-send"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Other Ways to Reach Us</h5>
                </div>
                <div class="card-body">
                    <div class="contact-method">
                        <h6><i class="bi bi-envelope text-primary"></i> General Support</h6>
                        <p>For technical support and general inquiries</p>
                        <a href="mailto:support@africoders.com" class="text-primary">support@africoders.com</a>
                    </div>

                    <div class="contact-method">
                        <h6><i class="bi bi-briefcase text-primary"></i> Business Inquiries</h6>
                        <p>For partnerships and business opportunities</p>
                        <a href="mailto:partners@africoders.com" class="text-primary">partners@africoders.com</a>
                    </div>

                    <div class="contact-method">
                        <h6><i class="bi bi-shield-check text-primary"></i> Legal Matters</h6>
                        <p>For legal inquiries and compliance</p>
                        <a href="mailto:legal@africoders.com" class="text-primary">legal@africoders.com</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Response Times</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><strong>Support Requests:</strong> Within 24 hours</li>
                        <li><strong>Business Inquiries:</strong> Within 2-3 business days</li>
                        <li><strong>Legal Matters:</strong> Within 5 business days</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Before You Contact Us</h5>
                </div>
                <div class="card-body">
                    <p>Please check these resources first:</p>
                    <ul>
                        <li><a href="{{ route('help.faq') }}">Frequently Asked Questions</a></li>
                        <li><a href="{{ route('help.articles') }}">Help Articles</a></li>
                        <li><a href="{{ route('help.support') }}">Support Center</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .contact-method {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .contact-method:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .contact-method h6 {
        margin-bottom: 0.5rem;
    }

    .contact-method p {
        color: #6b7280;
        margin-bottom: 0.25rem;
    }

    #submitBtn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .form-check-input:checked {
        background-color: var(--color-primary);
        border-color: var(--color-primary);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const recaptchaCheckbox = document.getElementById('recaptcha');
    const submitBtn = document.getElementById('submitBtn');
    const contactForm = document.getElementById('contactForm');

    // Enable/disable submit button based on reCAPTCHA checkbox
    recaptchaCheckbox.addEventListener('change', function() {
        submitBtn.disabled = !this.checked;
    });

    // Form submission validation
    contactForm.addEventListener('submit', function(e) {
        if (!recaptchaCheckbox.checked) {
            e.preventDefault();
            alert('Please confirm you are not a robot by checking the checkbox.');
            return false;
        }

        // Additional client-side validation can be added here
        const requiredFields = contactForm.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(function(field) {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return false;
        }

        // Show loading state
        submitBtn.innerHTML = '<i class="bi bi-clock-history"></i> Sending...';
        submitBtn.disabled = true;
    });

    // Reset form validation on input
    const formInputs = contactForm.querySelectorAll('input, select, textarea');
    formInputs.forEach(function(input) {
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
    });
});
</script>
@endpush
