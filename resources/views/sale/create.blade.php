<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Penjualan') }}
            </h2>
            <a href="/sale" class="py-2 px-3 rounded-lg text-white bg-indigo-500 shadow-lg hover:bg-indigo-700">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Tambah Data Penjualan') }}
                            </h2>
                    
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Tambah data penjualan mingguan.") }}
                            </p>
                        </header>
                    
                        <form method="post" action="/sale" class="mt-6 space-y-6">
                            @csrf
                    
                            <div>
                                <x-input-label for="week" :value="__('Minggu ke')" />
                                <x-text-input id="week" name="week" type="number" class="mt-1 block w-full" :value="old('week')" required autofocus autocomplete="week" />
                                <x-input-error class="mt-2" :messages="$errors->get('week')" />
                            </div>
                    
                            <div>
                                <x-input-label for="sale" :value="__('Penjualan')" />
                                <x-text-input id="sale" name="sale" type="number" class="mt-1 block w-full" :value="old('sale')" required autocomplete="sale" />
                                <x-input-error class="mt-2" :messages="$errors->get('sale')" />
                            </div>
                    
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>