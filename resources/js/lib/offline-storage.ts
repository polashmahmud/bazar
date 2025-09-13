// Offline Storage Manager using IndexedDB
// This handles offline data storage and synchronization

class OfflineStorageManager {
    private dbName = 'BazarOfflineDB';
    private dbVersion = 1;
    private db: IDBDatabase | null = null;

    // Store names
    private stores = {
        cart: 'cart_items',
        items: 'items',
        pendingActions: 'pending_actions',
        settings: 'settings',
    };

    async init(): Promise<void> {
        return new Promise((resolve, reject) => {
            const request = indexedDB.open(this.dbName, this.dbVersion);

            request.onerror = () => {
                console.error('Failed to open IndexedDB:', request.error);
                reject(request.error);
            };

            request.onsuccess = () => {
                this.db = request.result;
                console.log('IndexedDB initialized successfully');
                resolve();
            };

            request.onupgradeneeded = (event) => {
                const db = (event.target as IDBOpenDBRequest).result;

                // Create cart items store
                if (!db.objectStoreNames.contains(this.stores.cart)) {
                    const cartStore = db.createObjectStore(this.stores.cart, {
                        keyPath: 'id',
                        autoIncrement: true,
                    });
                    cartStore.createIndex('item_id', 'item_id', { unique: false });
                    cartStore.createIndex('month', 'month', { unique: false });
                    cartStore.createIndex('created_at', 'created_at', { unique: false });
                }

                // Create items store
                if (!db.objectStoreNames.contains(this.stores.items)) {
                    const itemsStore = db.createObjectStore(this.stores.items, {
                        keyPath: 'id',
                    });
                    itemsStore.createIndex('name', 'name', { unique: false });
                    itemsStore.createIndex('created_at', 'created_at', { unique: false });
                }

                // Create pending actions store
                if (!db.objectStoreNames.contains(this.stores.pendingActions)) {
                    const actionsStore = db.createObjectStore(this.stores.pendingActions, {
                        keyPath: 'id',
                        autoIncrement: true,
                    });
                    actionsStore.createIndex('action_type', 'action_type', { unique: false });
                    actionsStore.createIndex('timestamp', 'timestamp', { unique: false });
                }

                // Create settings store
                if (!db.objectStoreNames.contains(this.stores.settings)) {
                    db.createObjectStore(this.stores.settings, {
                        keyPath: 'key',
                    });
                }
            };
        });
    }

    // Cart operations
    async saveCartItem(item: any): Promise<void> {
        const transaction = this.db!.transaction([this.stores.cart], 'readwrite');
        const store = transaction.objectStore(this.stores.cart);

        const cartItem = {
            ...item,
            synced: false,
            offline_created: !navigator.onLine,
            last_modified: new Date().toISOString(),
        };

        await new Promise<void>((resolve, reject) => {
            const request = store.put(cartItem);
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }

    async getCartItems(): Promise<any[]> {
        const transaction = this.db!.transaction([this.stores.cart], 'readonly');
        const store = transaction.objectStore(this.stores.cart);

        return new Promise((resolve, reject) => {
            const request = store.getAll();
            request.onsuccess = () => resolve(request.result || []);
            request.onerror = () => reject(request.error);
        });
    }

    async deleteCartItem(cartId: string): Promise<void> {
        const transaction = this.db!.transaction([this.stores.cart], 'readwrite');
        const store = transaction.objectStore(this.stores.cart);

        await new Promise<void>((resolve, reject) => {
            // First find the item by cart_id
            const getRequest = store.getAll();
            getRequest.onsuccess = () => {
                const items = getRequest.result;
                const itemToDelete = items.find((item) => item.cart_id === cartId);

                if (itemToDelete) {
                    // Delete by the primary key (which is id)
                    const deleteRequest = store.delete(itemToDelete.id);
                    deleteRequest.onsuccess = () => resolve();
                    deleteRequest.onerror = () => reject(deleteRequest.error);
                } else {
                    resolve(); // Item not found, consider it already deleted
                }
            };
            getRequest.onerror = () => reject(getRequest.error);
        });
    }

    async updateCartItem(cartId: string, updates: any): Promise<void> {
        const transaction = this.db!.transaction([this.stores.cart], 'readwrite');
        const store = transaction.objectStore(this.stores.cart);

        await new Promise<void>((resolve, reject) => {
            // First find the item by cart_id
            const getAllRequest = store.getAll();
            getAllRequest.onsuccess = () => {
                const items = getAllRequest.result;
                const itemToUpdate = items.find((item) => item.cart_id === cartId);

                if (itemToUpdate) {
                    const updatedItem = {
                        ...itemToUpdate,
                        ...updates,
                        synced: false,
                        last_modified: new Date().toISOString(),
                    };

                    const putRequest = store.put(updatedItem);
                    putRequest.onsuccess = () => resolve();
                    putRequest.onerror = () => reject(putRequest.error);
                } else {
                    reject(new Error('Item not found'));
                }
            };
            getAllRequest.onerror = () => reject(getAllRequest.error);
        });
    }

    // Items operations
    async saveItem(item: any): Promise<void> {
        const transaction = this.db!.transaction([this.stores.items], 'readwrite');
        const store = transaction.objectStore(this.stores.items);

        await new Promise<void>((resolve, reject) => {
            const request = store.put(item);
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }

    async getItems(): Promise<any[]> {
        const transaction = this.db!.transaction([this.stores.items], 'readonly');
        const store = transaction.objectStore(this.stores.items);

        return new Promise((resolve, reject) => {
            const request = store.getAll();
            request.onsuccess = () => resolve(request.result || []);
            request.onerror = () => reject(request.error);
        });
    }

    // Pending actions for sync
    async addPendingAction(action: {
        action_type: 'cart_add' | 'cart_update' | 'cart_delete' | 'item_add';
        data: any;
        url: string;
        method: string;
    }): Promise<void> {
        const transaction = this.db!.transaction([this.stores.pendingActions], 'readwrite');
        const store = transaction.objectStore(this.stores.pendingActions);

        const pendingAction = {
            ...action,
            timestamp: new Date().toISOString(),
            attempts: 0,
            max_attempts: 3,
        };

        await new Promise<void>((resolve, reject) => {
            const request = store.add(pendingAction);
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }

    async getPendingActions(): Promise<any[]> {
        const transaction = this.db!.transaction([this.stores.pendingActions], 'readonly');
        const store = transaction.objectStore(this.stores.pendingActions);

        return new Promise((resolve, reject) => {
            const request = store.getAll();
            request.onsuccess = () => resolve(request.result || []);
            request.onerror = () => reject(request.error);
        });
    }

    async removePendingAction(id: number): Promise<void> {
        const transaction = this.db!.transaction([this.stores.pendingActions], 'readwrite');
        const store = transaction.objectStore(this.stores.pendingActions);

        await new Promise<void>((resolve, reject) => {
            const request = store.delete(id);
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }

    // Settings operations
    async saveSetting(key: string, value: any): Promise<void> {
        const transaction = this.db!.transaction([this.stores.settings], 'readwrite');
        const store = transaction.objectStore(this.stores.settings);

        await new Promise<void>((resolve, reject) => {
            const request = store.put({ key, value });
            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }

    async getSetting(key: string): Promise<any> {
        const transaction = this.db!.transaction([this.stores.settings], 'readonly');
        const store = transaction.objectStore(this.stores.settings);

        return new Promise((resolve, reject) => {
            const request = store.get(key);
            request.onsuccess = () => resolve(request.result?.value);
            request.onerror = () => reject(request.error);
        });
    }

    // Sync operations
    async syncData(): Promise<void> {
        if (!navigator.onLine) {
            console.log('Device is offline, skipping sync');
            return;
        }

        try {
            const pendingActions = await this.getPendingActions();

            for (const action of pendingActions) {
                try {
                    const response = await fetch(action.url, {
                        method: action.method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.getCSRFToken(),
                        },
                        body: action.data ? JSON.stringify(action.data) : undefined,
                    });

                    if (response.ok) {
                        // Action succeeded, remove from pending
                        await this.removePendingAction(action.id);
                        console.log(`Synced action: ${action.action_type}`);
                    } else {
                        // Action failed, increment attempts
                        action.attempts += 1;
                        if (action.attempts >= action.max_attempts) {
                            await this.removePendingAction(action.id);
                            console.error(`Action failed after ${action.max_attempts} attempts:`, action);
                        }
                    }
                } catch (error) {
                    console.error('Sync error for action:', action, error);
                    action.attempts += 1;
                }
            }
        } catch (error) {
            console.error('Sync failed:', error);
        }
    }

    // Utility methods
    private getCSRFToken(): string {
        const meta = document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement;
        return meta?.content || '';
    }

    // Clear all offline data
    async clearOfflineData(): Promise<void> {
        const transaction = this.db!.transaction([this.stores.cart, this.stores.items, this.stores.pendingActions], 'readwrite');

        await Promise.all([
            new Promise<void>((resolve, reject) => {
                const request = transaction.objectStore(this.stores.cart).clear();
                request.onsuccess = () => resolve();
                request.onerror = () => reject(request.error);
            }),
            new Promise<void>((resolve, reject) => {
                const request = transaction.objectStore(this.stores.items).clear();
                request.onsuccess = () => resolve();
                request.onerror = () => reject(request.error);
            }),
            new Promise<void>((resolve, reject) => {
                const request = transaction.objectStore(this.stores.pendingActions).clear();
                request.onsuccess = () => resolve();
                request.onerror = () => reject(request.error);
            }),
        ]);
    }

    // Get storage stats
    async getStorageStats(): Promise<{
        cartItems: number;
        items: number;
        pendingActions: number;
    }> {
        const [cartItems, items, pendingActions] = await Promise.all([this.getCartItems(), this.getItems(), this.getPendingActions()]);

        return {
            cartItems: cartItems.length,
            items: items.length,
            pendingActions: pendingActions.length,
        };
    }
}

// Create global instance
const offlineStorage = new OfflineStorageManager();

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        offlineStorage.init().catch(console.error);
    });
} else {
    offlineStorage.init().catch(console.error);
}

// Auto-sync when coming back online
window.addEventListener('online', () => {
    console.log('Device came back online, syncing data...');
    offlineStorage.syncData().catch(console.error);
});

// Export for use in Vue components
(window as any).offlineStorage = offlineStorage;

export default offlineStorage;
