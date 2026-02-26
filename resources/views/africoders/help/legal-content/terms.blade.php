<div class="legal-document">
    <h2>Terms of Service</h2>

    <p><strong>Effective Date:</strong> {{ date('F j, Y') }}</p>

    <h3>1. Acceptance of Terms</h3>
    <p>By accessing and using the Africoders platform and services, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to these terms, you should not use our services.</p>

    <h3>2. Description of Service</h3>
    <p>Africoders provides a platform for developers, creators, and technology enthusiasts to connect, collaborate, and build innovative solutions. Our services include:</p>
    <ul>
        <li>User identity and authentication services</li>
        <li>Community forums and collaboration tools</li>
        <li>Developer resources and documentation</li>
        <li>Business networking and partnership opportunities</li>
    </ul>

    <h3>3. User Responsibilities</h3>
    <p>You are responsible for:</p>
    <ul>
        <li>Maintaining the confidentiality of your account credentials</li>
        <li>All activities that occur under your account</li>
        <li>Ensuring your use of our services complies with all applicable laws</li>
        <li>Respecting the rights and intellectual property of others</li>
    </ul>

    <h3>4. Prohibited Uses</h3>
    <p>You may not use our services for any illegal or unauthorized purpose, including but not limited to:</p>
    <ul>
        <li>Violating any local, state, national, or international law</li>
        <li>Transmitting or procuring the sending of any advertising or promotional material</li>
        <li>Impersonating or attempting to impersonate Africoders or its employees</li>
        <li>Engaging in any conduct that restricts or inhibits anyone's use of the services</li>
    </ul>

    <h3>5. Privacy</h3>
    <p>Your privacy is important to us. Please review our <a href="{{ route('help.legal', 'privacy') }}">Privacy Policy</a>, which also governs your use of the services.</p>

    <h3>6. Modifications</h3>
    <p>We reserve the right to modify these terms at any time. We will notify users of any material changes by posting the new Terms of Service on this page.</p>

    <h3>7. Contact Information</h3>
    <p>If you have any questions about these Terms of Service, please contact us at <a href="mailto:legal@africoders.com">legal@africoders.com</a>.</p>
</div>

<style>
.legal-document {
    line-height: 1.6;
}

.legal-document h2 {
    color: var(--color-primary);
    margin-bottom: 1rem;
}

.legal-document h3 {
    color: var(--color-secondary);
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.legal-document ul {
    margin-bottom: 1rem;
}

.legal-document li {
    margin-bottom: 0.5rem;
}

.legal-document a {
    color: var(--color-primary);
    text-decoration: none;
}

.legal-document a:hover {
    text-decoration: underline;
}
</style>
