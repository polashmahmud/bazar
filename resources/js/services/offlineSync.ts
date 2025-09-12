import localforage from 'localforage'
import axios from 'axios'

export interface Item {
  id?: number
  name: string
  category: string
  image?: string
  quantity: number
  price: number
  month: string
  is_done: boolean
  user_id?: number
  created_at?: string
  updated_at?: string
  synced_at?: string | null
}

export interface OfflineItem extends Item {
  offline_id: string
  needs_sync: boolean
}

class OfflineSyncService {
  private store = localforage.createInstance({
    name: 'GroceryApp',
    storeName: 'items'
  })

  private syncQueue = localforage.createInstance({
    name: 'GroceryApp',
    storeName: 'sync_queue'
  })

  // Generate unique offline ID
  private generateOfflineId(): string {
    return `offline_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`
  }

  // Check if online
  private isOnline(): boolean {
    return navigator.onLine
  }

  // Save item offline
  async saveOffline(item: Omit<Item, 'id'>): Promise<OfflineItem> {
    const offlineItem: OfflineItem = {
      ...item,
      offline_id: this.generateOfflineId(),
      needs_sync: true
    }

    await this.store.setItem(offlineItem.offline_id, offlineItem)
    await this.addToSyncQueue(offlineItem.offline_id)

    if (this.isOnline()) {
      this.attemptSync()
    }

    return offlineItem
  }

  // Update item offline
  async updateOffline(offlineId: string, updates: Partial<Item>): Promise<OfflineItem | null> {
    const item = await this.store.getItem<OfflineItem>(offlineId)
    if (!item) return null

    const updatedItem: OfflineItem = {
      ...item,
      ...updates,
      needs_sync: true
    }

    await this.store.setItem(offlineId, updatedItem)
    await this.addToSyncQueue(offlineId)

    if (this.isOnline()) {
      this.attemptSync()
    }

    return updatedItem
  }

  // Delete item offline
  async deleteOffline(offlineId: string): Promise<boolean> {
    await this.store.removeItem(offlineId)
    await this.removeFromSyncQueue(offlineId)
    return true
  }

  // Get all offline items
  async getAllOffline(): Promise<OfflineItem[]> {
    const items: OfflineItem[] = []
    await this.store.iterate<OfflineItem, void>((item: OfflineItem) => {
      items.push(item)
    })
    return items.sort((a, b) => new Date(b.created_at || '').getTime() - new Date(a.created_at || '').getTime())
  }

  // Get items for specific month
  async getItemsForMonth(month: string): Promise<OfflineItem[]> {
    const allItems = await this.getAllOffline()
    return allItems.filter(item => item.month === month)
  }

  // Add to sync queue
  private async addToSyncQueue(offlineId: string): Promise<void> {
    const queue = await this.syncQueue.getItem<string[]>('pending') || []
    if (!queue.includes(offlineId)) {
      queue.push(offlineId)
      await this.syncQueue.setItem('pending', queue)
    }
  }

  // Remove from sync queue
  private async removeFromSyncQueue(offlineId: string): Promise<void> {
    const queue = await this.syncQueue.getItem<string[]>('pending') || []
    const filtered = queue.filter((id: string) => id !== offlineId)
    await this.syncQueue.setItem('pending', filtered)
  }

  // Attempt to sync with server
  async attemptSync(): Promise<void> {
    if (!this.isOnline()) return

    const queue = await this.syncQueue.getItem<string[]>('pending') || []
    if (queue.length === 0) return

    try {
      const itemsToSync: OfflineItem[] = []
      
      for (const offlineId of queue) {
        const item = await this.store.getItem<OfflineItem>(offlineId)
        if (item && item.needs_sync) {
          itemsToSync.push(item)
        }
      }

      if (itemsToSync.length === 0) return

      // Send items to server
      const response = await axios.post('/items/bulk-sync', {
        items: itemsToSync.map(item => ({
          name: item.name,
          category: item.category,
          image: item.image,
          quantity: item.quantity,
          price: item.price,
          month: item.month,
          is_done: item.is_done,
          offline_id: item.offline_id
        }))
      })

      if (response.data.success) {
        // Remove synced items from offline storage
        for (const syncedItem of response.data.synced_items) {
          await this.store.removeItem(syncedItem.offline_id)
          await this.removeFromSyncQueue(syncedItem.offline_id)
        }

        console.log(`Successfully synced ${response.data.synced_items.length} items`)
      }
    } catch (error) {
      console.error('Sync failed:', error)
    }
  }

  // Clear all offline data
  async clearOfflineData(): Promise<void> {
    await this.store.clear()
    await this.syncQueue.clear()
  }

  // Get sync status
  async getSyncStatus(): Promise<{ pendingCount: number, isOnline: boolean }> {
    const queue = await this.syncQueue.getItem<string[]>('pending') || []
    return {
      pendingCount: queue.length,
      isOnline: this.isOnline()
    }
  }

  // Setup auto-sync when coming online
  setupAutoSync(): void {
    window.addEventListener('online', () => {
      console.log('Connection restored, attempting sync...')
      this.attemptSync()
    })

    window.addEventListener('offline', () => {
      console.log('Connection lost, switching to offline mode')
    })
  }
}

export const offlineSyncService = new OfflineSyncService()
