// Debug helper for browser console
window.debugApp = {
    testAuth: async () => {
        try {
            const response = await fetch('/test-auth');
            const data = await response.json();
            console.log('Auth Status:', data);
            
            // Log to server
            await fetch('/debug-log', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                },
                credentials: 'include',
                body: JSON.stringify({
                    type: 'auth_check',
                    message: 'Authentication status checked',
                    data: data
                })
            });
            
            return data;
        } catch (error) {
            console.error('Auth test failed:', error);
            
            // Log error to server
            await fetch('/debug-log', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                },
                credentials: 'include',
                body: JSON.stringify({
                    type: 'auth_check_error',
                    message: 'Authentication check failed',
                    data: { error: error.message }
                })
            });
        }
    },
    
    testItemCreate: async () => {
        try {
            const response = await fetch('/test-item', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                credentials: 'include',
                body: JSON.stringify({
                    name: 'Debug Test Item'
                })
            });
            const data = await response.json();
            console.log('Item Create Test:', data);
            
            // Log to server
            await fetch('/debug-log', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                },
                credentials: 'include',
                body: JSON.stringify({
                    type: 'item_create_test',
                    message: 'Item creation test completed',
                    data: data
                })
            });
            
            return data;
        } catch (error) {
            console.error('Item create test failed:', error);
            
            // Log error to server
            await fetch('/debug-log', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                },
                credentials: 'include',
                body: JSON.stringify({
                    type: 'item_create_error',
                    message: 'Item creation test failed',
                    data: { error: error.message }
                })
            });
        }
    },

    checkCookies: () => {
        const cookieData = {
            cookies: document.cookie,
            csrf_token: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        };
        
        console.log('Cookie Data:', cookieData);
        
        // Log to server
        fetch('/debug-log', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            },
            credentials: 'include',
            body: JSON.stringify({
                type: 'cookie_check',
                message: 'Cookie information checked',
                data: cookieData
            })
        });
        
        return cookieData;
    },

    // Auto-run debugging after PIN login
    autoDebug: async () => {
        console.log('Starting auto-debug...');
        await debugApp.checkCookies();
        await debugApp.testAuth();
        await debugApp.testItemCreate();
        console.log('Auto-debug completed. Check Laravel logs for details.');
    }
};

console.log('Debug helper loaded. Use window.debugApp.autoDebug() after PIN login for complete test.');
