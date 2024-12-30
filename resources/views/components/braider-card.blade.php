<style>
.work1, .work2, .work3, .work4 {
    position: absolute;
    transition: transform 0.5s ease, opacity 0.5s ease;
}

.work1:hover {
    transform: translateY(120px);
}

.work1:hover ~ .work4 {
    transform: translateY(-120px) translateX(100px) scale(0.8) rotate(15deg);
}

.work1:hover ~ .work3 {
    transform: translateY(-120px) translateX(-100px) scale(0.8) rotate(-15deg);
}

.work1:hover ~ .work2 {
    transform: translateY(-120px) scale(0.8);
}


.work1 {
    z-index: 4;
}

.work2 {
    z-index: 3;
    transform: translateY(0) translateX(0) scale(1);
}

.work3 {
    z-index: 2;
    transform: translateY(0) translateX(0) scale(1);
}

.work4 {
    z-index: 1;
    transform: translateY(0) translateX(0) scale(1);
}
</style>

<div class="p-10 h-100 w-100 flex flex-col">
    <a href="/braiders/{{$braider->id}}">
    <div class="relative h-80 w-80 mb-1 border-tahini">
        <div class="work1 absolute h-80 w-80 mb-1 border-tahini"><img class="object-cover h-full w-full" src="{{ asset('storage/' . $braider->headshot) }}" alt=""></div>
        <div class="work2 absolute h-80 w-80 mb-1 border-tahini"> <img class="object-cover h-full w-full" src="{{$braider->work_image1}}" alt=""></div>
    </div>
    <div>
        <p class="text-tahini text-4xl font-bold"> {{ $braider->user->name }} </p>
        <p class="text-tahini">{{ $braider->bio }}</p>
        <!-- <p class="text-tahini">Specialty: Box braids and cornrows</p> -->
        <p class="text-tahini">Price range:${{ $braider->min_price }} ~ ${{ $braider->max_price }}</p>
        <!-- <p class="text-tahini">Usual availability: Weekday evenings</p> -->
    </div>
    </a>
</div>