<x-filament-widgets::widget>
    <x-filament::section>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Views -->
            <x-filament::card class="flex items-center space-x-4 p-6">
                <div class="bg-primary-100 dark:bg-primary-900 p-3 rounded-full">
                    <x-heroicon-o-eye class="w-6 h-6 text-primary-600 dark:text-primary-300" />
                </div>
                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total Views</div>
                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                        {{ number_format($ViewCount) }}
                    </div>
                </div>
            </x-filament::card>

            <!-- Upvotes -->
            <x-filament::card class="p-6 space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-success-100 dark:bg-success-900 p-3 rounded-full">
                        <x-heroicon-o-hand-thumb-up class="w-6 h-6 text-success-600 dark:text-success-400" />
                    </div>
                    <div class="text-lg font-semibold text-success-700 dark:text-success-300">Upvotes</div>
                </div>

                @php
                    $totalVotes = $UpVotes + $DownVotes;
                    $upPercent = $totalVotes > 0 ? ($UpVotes / $totalVotes) * 100 : 0;
                @endphp

                <div class="text-sm font-medium text-success-600 dark:text-success-400">
                    {{ number_format($UpVotes) }} upvotes — {{ round($upPercent, 1) }}%
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700">
                    <div class="h-full bg-success-500 rounded-full transition-all duration-300" style="width: {{ $upPercent }}%"></div>
                </div>
            </x-filament::card>

            <!-- Downvotes -->
            <x-filament::card class="p-6 space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-danger-100 dark:bg-danger-900 p-3 rounded-full">
                        <x-heroicon-o-hand-thumb-down class="w-6 h-6 text-danger-600 dark:text-danger-400" />
                    </div>
                    <div class="text-lg font-semibold text-danger-700 dark:text-danger-300">Downvotes</div>
                </div>

                @php
                    $downPercent = $totalVotes > 0 ? ($DownVotes / $totalVotes) * 100 : 0;
                @endphp

                <div class="text-sm font-medium text-danger-600 dark:text-danger-400">
                    {{ number_format($DownVotes) }} downvotes — {{ round($downPercent, 1) }}%
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden dark:bg-gray-700">
                    <div class="h-full bg-danger-500 rounded-full transition-all duration-300" style="width: {{ $downPercent }}%"></div>
                </div>
            </x-filament::card>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
