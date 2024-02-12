<div class="">
    <div class="swiper">
        <div class="swiper-wrapper">
            <div
                 class="swiper-slide relative w-full mx-auto h-[250px] rounded-xl bg-gradient-to-r from-cyan-500 to-blue-500">
                <img class="absolute right-0" src="{{ asset('images/banner1.png') }}" alt="banner photo">

                <div class="absolute top-1/2 -translate-y-1/2 left-10">
                    <span class="text-white text-sm">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</span>
                    <h3 class="text-white text-2xl w-[500px]">Lorem ipsum dolor sit amet consectetur adipisicing elit. At
                        consequuntur rem laboriosam</h3>
                </div>
            </div>
            <div
                 class="swiper-slide w-full mx-auto relative h-[250px] rounded-xl bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                <img class="absolute w-[200px] right-28" src="{{ asset('images/banner2.png') }}" alt="banner photo">
                <div class="absolute top-1/2 -translate-y-1/2 left-10">
                    <span class="text-white text-sm">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</span>
                    <h3 class="text-white text-2xl w-[500px]">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        At consequuntur rem laboriosam</h3>
                </div>
            </div>
            <div
                 class="swiper-slide w-full mx-auto h-[250px] relative rounded-xl bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90%">
                <img class="absolute w-[300px]  right-28 bottom-0" src="{{ asset('images/banner3.png') }}"
                     alt="banner photo">
                <div class="absolute top-1/2 -translate-y-1/2 left-10">
                    <span class="text-white text-sm">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</span>
                    <h3 class="text-white text-2xl w-[500px]">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        At consequuntur rem laboriosam</h3>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>

<script type="module">
    const swiper = new Swiper('.swiper', {
        directives: 'vertical',
        loop : true,
        speed: 400,
        spaceBetween: 100,
        pagination: {
            el: '.swiper-pagination',
        },
        autoplay: {
            delay: 10000
        }
    });
    console.log(swiper);
</script>
