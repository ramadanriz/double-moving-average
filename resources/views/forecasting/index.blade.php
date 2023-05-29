<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Peramalan Double Moving Average') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl p-4 mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium">
                            {{ __('Masukkan Jumlah Periode') }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Jumlah periode dalam moving average adalah jumlah data yang digunakan untuk menghitung rata-rata bergerak pada suatu periode waktu tertentu.") }}
                        </p>
                    </header>
                
                    <form method="POST" action="/forecasting" class="mt-6 space-y-6">
                        @csrf      
                        <div>
                            <x-input-label for="periode" :value="__('Periode')" />
                            <x-text-input id="periode" name="periode" type="number" class="mt-1 block w-full" value="{{ request('periode') }}" required autofocus autocomplete="periode" min="1" max="{{ $index-1 }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('periode')" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button name="generate">{{ __('Submit') }}</x-primary-button>
                        </div>
                    </form>
                </section>
        </div>
    </div>

    @if (isset($_POST['generate']))
    {{-- @dd(end($data2)) --}}
    <div class="grid gap-7 mt-8 max-w-7xl p-4 mx-auto sm:px-6 lg:px-8 overflow-hidden shadow-sm sm:rounded-lg">
      <h2 class="text-xl font-semibold leading-tight capitalize">
        {{ __('Peramalan') }} Menggunakan {{ $_POST['periode'] }} Periode
      </h2>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 w-full">
        <div class="flex items-center p-4 w-full bg-white rounded-lg overflow-hidden shadow hover:shadow-md">
          <div>
            <p class="font-bold text-gray-800">{{ end($data2) }}</p>
            <p class="text-sm text-gray-600">Prediksi Minggu ke-{{ $nextPeriod }}</p>
          </div>
        </div>
      </div>

      <div class="grid gap-2">
        <h2 class="text-xl font-semibold leading-tight capitalize">
          {{ __('tabel hasil forecasting') }}
        </h2>
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
          <table class="w-full text-sm text-center">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                  <tr>
                      <th scope="col" class="px-6 py-3">Minggu ke</th>
                      <th scope="col" class="px-6 py-3">Data Aktual</th>
                      <th scope="col" class="px-6 py-3">Single Moving Average</th>
                      <th scope="col" class="px-6 py-3">Double Moving Average</th>
                  </tr>
              </thead>
              <tbody>
              @for ($i=0; $i <  count($hasil['data']) ; $i++)
                <tr class="bg-white border-b">
                  <td class="px-6 py-4">{{ $hasil['data'][$i][0] }}</td>
                  <td class="px-6 py-4">{{ $hasil['data'][$i][1] }}</td>
                  <td class="px-6 py-4">{{ $hasil['MA'][$i] }}</td>
              </tr>
              @endfor
              </tbody>
          </table>
      </div>
      </div>
    </div>
    @endif
</x-app-layout>