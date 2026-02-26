/**
 * Handle nonce-based authentication from cross-domain login
 * This script exchanges a nonce for a JWT token and sets the auth cookie
 * Place this in your layout's head or before closing body tag
 */
(function() {
    console.log('Auth nonce handler: Script loaded');

    // Wait for DOM to be fully ready
    function processNonce() {
        // Get nonce from URL query parameter
        const params = new URLSearchParams(window.location.search);
        const authNonce = params.get('auth_nonce');

        console.log('[Auth Handler] authNonce from URL:', authNonce ? 'PRESENT (' + authNonce.substring(0, 10) + '...)' : 'NOT FOUND');

        if (!authNonce) {
            console.log('[Auth Handler] No nonce in URL, skipping');
            return; // No nonce, nothing to do
        }

        // Get the ID service base URL from meta tag (set in layout)
        const metaTag = document.querySelector('meta[name="id-service-url"]');
        const idServiceUrl = metaTag?.content;

        console.log('[Auth Handler] Meta tag found:', metaTag ? 'YES' : 'NO');
        console.log('[Auth Handler] Meta tag content:', idServiceUrl);

        if (!idServiceUrl) {
            console.error('[Auth Handler] CRITICAL: id-service-url meta tag not found or empty!');
            console.error('[Auth Handler] Available meta tags:', Array.from(document.querySelectorAll('meta')).map(m => `${m.name}=${m.content}`).join(', '));
            return;
        }

        const exchangeUrl = `${idServiceUrl}/auth/exchange-nonce`;
        console.log('[Auth Handler] Will attempt exchange at:', exchangeUrl);
        console.log('[Auth Handler] With nonce:', authNonce.substring(0, 20) + '...');

        // Exchange nonce for JWT token
        fetch(exchangeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            credentials: 'omit', // Don't send cookies to different domain
            body: JSON.stringify({
                nonce: authNonce,
            }),
        })
        .then(response => {
            console.log('[Auth Handler] FETCH RESPONSE:', {
                status: response.status,
                statusText: response.statusText,
                ok: response.ok,
                type: response.type,
                headers: {
                    contentType: response.headers.get('content-type')
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('[Auth Handler] RESPONSE DATA RECEIVED:', {
                hasToken: !!data.token,
                hasUser: !!data.user,
                userData: data.user
            });

            if (!data.token) {
                throw new Error('Response missing token field');
            }

            console.log('[Auth Handler] TOKEN VALID, setting cookie...');

            // Store JWT in cookie
            // Calculate expiration (assuming 1 hour = 3600 seconds)
            const expiresIn = 3600;
            const date = new Date();
            date.setTime(date.getTime() + (expiresIn * 1000));
            const expires = `expires=${date.toUTCString()}`;

            // Note: We're setting cookie on the current domain (kortextools.test), not the ID service domain
            // So SameSite=Lax should work fine
            const cookieStr = `auth_token=${data.token}; path=/; ${expires}; SameSite=Lax`;
            document.cookie = cookieStr;

            console.log('[Auth Handler] COOKIE SET successfully');
            console.log('[Auth Handler] Current domain:', window.location.hostname);
            console.log('[Auth Handler] Cookie details: path=/, SameSite=Lax, expires=1 hour');
            console.log('[Auth Handler] Token length:', data.token.length, 'characters');

            // Remove nonce from URL
            const urlWithoutNonce = window.location.origin + window.location.pathname;
            window.history.replaceState({}, document.title, urlWithoutNonce);
            console.log('[Auth Handler] Nonce removed from URL');

            // Set authentication state in localStorage for immediate UI updates
            if (data.user) {
                localStorage.setItem('auth_user', JSON.stringify(data.user));
                // Dispatch custom event for UI components to listen to
                window.dispatchEvent(new CustomEvent('auth-complete', { detail: data.user }));
                console.log('[Auth Handler] User data stored in localStorage');
            }

            console.log('[Auth Handler] ✓ AUTHENTICATION SUCCESSFUL - reloading page');

            // Reload the page to apply auth state
            setTimeout(() => {
                location.reload();
            }, 100);
        })
        .catch(error => {
            console.error('[Auth Handler] ✗ ERROR OCCURRED:', {
                message: error.message,
                stack: error.stack,
                nonce: authNonce.substring(0, 20) + '...',
                url: exchangeUrl
            });

            // On error, remove the nonce from URL so user doesn't retry endlessly
            const urlWithoutNonce = window.location.origin + window.location.pathname;
            window.history.replaceState({}, document.title, urlWithoutNonce);
            console.error('[Auth Handler] Nonce removed due to error');
        });
    }

    // Try to process nonce immediately (should work as script is at end of body)
    if (document.readyState === 'loading') {
        console.log('[Auth Handler] DOM still loading, waiting for complete...');
        document.addEventListener('DOMContentLoaded', processNonce);
    } else {
        console.log('[Auth Handler] DOM already loaded, processing nonce...');
        processNonce();
    }
})();

