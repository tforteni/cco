<style>

.photo {
    transition: translate 1.5s ease, rotate 1.5s ease;
}   

.off-screen1 {
    position: absolute;
    translate: -250px;
    rotate: -30deg;
}

.on-screen1 {
    position: absolute;
    translate: 400px;
    transform: translateY(200px);
    rotate: 30deg;
}

.off-screen2 {
    position: absolute;
    translate: 1200px;
    rotate: 0deg;
}

.on-screen2 {
    position: relative;
    translate: 610px;
    transform: translateY(90px);
    rotate: -30deg;
    z-index:2;
}

.off-screen3 {
    position: absolute;
    translate: -250px;
    rotate: 0deg;
}

.on-screen3 {
    position: absolute;
    translate: 500px;
    transform: translateY(100px);
    rotate: 10deg;
    z-index:1;
}

.off-screen4 {
    position: absolute;
    translate: 1200px;
    rotate: 0deg;
}

.on-screen4 {
    position: absolute;
    translate: 800px;
    transform: translateY(50px);
    rotate: -10deg;
    z-index:0;
}

.off-screen5 {
    position: absolute;
    translate: 1200px;
    rotate: 0deg;
}

.on-screen5 {
    position: absolute;
    translate: 520px;
    transform: translateY(-200px);
    rotate: -10deg;
    z-index:3;
}

.off-screen6 {
    position: absolute;
    translate: 1200px;
    rotate: 0deg;
}

.on-screen6 {
    position: absolute;
    translate: 1040px;
    transform: translateY(-100px);
    rotate: 5deg;
    z-index:3;
}

.discover-braiders{
    position: absolute;
    translate: 940px;
    transform: translateY(600px);
    rotate: 0deg;
}

.student-ambassador{
    position: absolute;
    translate: 250px;
    transform: translateY(1170px) scale(1.2);
    rotate: 0deg;
}

.learn-events {
    position: absolute;
    translate: 950px;
    transform: translateY(1370px);
    rotate: 0deg;
}

/* p //If I want the photos and the text to be like overlapping then I will use p instead of text-link*/ 
.text-link {
    display: inline-block;
    position: relative;
    cursor: pointer;
}

.underline-on-hover::after {
    background-color: #f7ebcb;
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -3px; /* Position the underline slightly below the text */
    left: 0;
    transition: width 0.3s ease;
}

.underline-on-hover:hover::after {
    width: 100%;
}
</style>

<x-layout>
    <div class="absolute">
        @for($x = 1; $x < 7; $x++)
            @if($x == 2 || $x == 3)
            <img id="photo{{$x}}" class="h-60 w-auto photo off-screen{{$x}}" src="images/photo{{$x}}.jpg" alt="">
            @else
            <img id="photo{{$x}}" class="h-80 w-auto photo off-screen{{$x}}" src="images/photo{{$x}}.jpg" alt="">
            @endif
        @endfor
    </div>
    <div class="welcome-text mt-60 flex flex-col justify-center items-center">
        <p class="text-tahini text-6xl font-schoolbook">Welcome</p>
        <p class="text-tahini text-2xl">to the</p>
        <p class="text-tahini text-9xl font-schoolbook">Coily Curly Office</p>
        <p class="pt-10 text-light text-4xl font-schoolbook">Sponsored by L'Oreal</p>
    </div>
    <div id="para1" class="text-xl opacity-0 transition duration-700 ease-in-out mt-60 flex flex-col justify-center items-center">
        <p class="text-tahini font-semibold"> Discover new hairstyles, braiders near you, and a community of like-minded people who love their hair!  </p>
    </div>
    <div id="para2" class="mt-60 ml-80 opacity-0 transition duration-700 ease-in-out">
        <a href="/braiders" class="text-link text-tahini text-4xl font-schoolbook underline-on-hover" >Find braiders on campus</a>
    </div>
    <div id="para3" class="mt-80 ml-80 pl-80 opacity-0 transition duration-700 ease-in-out">
        <a href="/ambassadors"class="text-link text-tahini text-4xl font-schoolbook underline-on-hover">Become a student abassador</a>
    </div>
    <div id="para4" class="mt-80 ml-80 opacity-0 transition duration-700 ease-in-out">
        <a href="/calendar" class="text-link text-tahini text-4xl font-schoolbook underline-on-hover">Learn about upcoming events</a>
    </div>
    <div class="mt-80 flex flex-col justify-center items-center">
    </div>
</x-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const photos = document.getElementsByClassName("photo");
    var para1 = document.getElementById("para1");
    var para2 = document.getElementById("para2");
    var para3 = document.getElementById("para3");
    var para4 = document.getElementById("para4");
    var photo1 = document.getElementById("photo1");
    var photo3 = document.getElementById("photo3");
    var photo4 = document.getElementById("photo4");

    function checkScroll() {
        let counter = 1;
        Array.from(photos).forEach(photo => {
            photo.classList.remove(`off-screen${counter}`);
            photo.classList.add(`on-screen${counter}`);
            counter++;
        });

        if (window.scrollY > 30)
        {
            para1.classList.remove('opacity-0');
            para1.classList.add('opacity-100');
        }

        if (window.scrollY > 400)
        {
            photo4.classList.remove('on-screen4');
            photo4.classList.add('discover-braiders');
        }

        if (window.scrollY > 400)
        {
            para2.classList.remove('opacity-0');
            para2.classList.add('opacity-100');
        }

        if (window.scrollY > 700)
        {
            photo1.classList.remove('on-screen1');
            photo1.classList.add('student-ambassador');
        }

        if (window.scrollY > 800)
        {
            para3.classList.remove('opacity-0');
            para3.classList.add('opacity-100');
        }

        if (window.scrollY > 1050)
        {
            photo3.classList.remove('on-screen3');
            photo3.classList.add('learn-events');
        }

        if (window.scrollY > 1100)
        {
            console.log('bruh');
            para4.classList.remove('opacity-0');
            para4.classList.add('opacity-100');
        }
    }

    window.onscroll = checkScroll;

});
</script>