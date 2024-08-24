<x-layout>
    <div class="welcome-text mt-10 flex flex-col justify-center items-center">
        <p class="text-tahini text-4xl font-schoolbook">Meet our braiders!</p>
        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($braiders as $braider)
            <x-braider-card :braider="$braider" >
            </x-braider-card>
        @endforeach
        </div>
    </div>
</x-layout>

<script>

</script>