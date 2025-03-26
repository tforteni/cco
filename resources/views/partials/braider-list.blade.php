@if($braiders->isEmpty())
    <p class="text-center text-lg text-[#f7ebcb] py-6">No braiders found for this hairstyle. Coming Soon!</p>
@else
    @foreach($braiders as $braider)
        <x-braider-card :braider="$braider" />
    @endforeach
@endif
