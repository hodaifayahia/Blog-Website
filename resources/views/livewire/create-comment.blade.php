<div  class="max-w-full mx-auto p-4 bg-white rounded-lg shadow">
    <form wire:submit.prevent="submitComment" class="space-y-4">
        <div>
            <textarea
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                wire:model="comment"
                rows="4"
                placeholder="Share your thoughts..."
            >{{ $comment }}</textarea>
            
            @error('comment')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <button
                type="button"
                @click="$dispatch('closeModal')"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
            >
                Cancel
            </button>
            
            <button
                type="submit"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                Submit
            </button>
        </div>
    </form>
</div>