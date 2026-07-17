<?php
    $heroSlides = [
        [
            'title' => 'Keindahan dalam Setiap Detail',
            'subtitle' => 'Nail Art - Brow Bomber - Skincare',
            'image' => 'hero-1.jpg',
            'primaryLabel' => 'Pesan Sekarang',
            'primaryRoute' => route('booking.create'),
            'secondaryLabel' => 'Belanja Produk',
            'secondaryRoute' => route('products.index'),
        ],
        [
            'title' => 'Glamor yang Lembut, Ruang yang Tenang',
            'subtitle' => 'Hair Ritual - Skin Care - Self Pamper',
            'image' => 'hero-2.jpg',
            'primaryLabel' => 'Pesan Sesi',
            'primaryRoute' => route('booking.create'),
            'secondaryLabel' => 'Lihat Layanan',
            'secondaryRoute' => route('services.index'),
        ],
        [
            'title' => 'Momen Kecantikan Pilihan',
            'subtitle' => 'Premium Touch - Warm Experience - Refined Results',
            'image' => 'hero-3.jpg',
            'primaryLabel' => 'Pesan Sekarang',
            'primaryRoute' => route('booking.create'),
            'secondaryLabel' => 'Jelajahi Produk',
            'secondaryRoute' => route('products.index'),
        ],
    ];
?>

<?php $__env->startSection('content'); ?>

<section class="relative overflow-hidden" data-hero-slider data-autoplay="5000">
    <div class="relative h-[560px] sm:h-[640px]">
        <?php $__currentLoopData = $heroSlides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article data-slide
                class="absolute inset-0 bg-cover bg-center transition-opacity duration-700 <?php echo e($index === 0 ? 'opacity-100' : 'opacity-0 pointer-events-none'); ?>"
                style="background-image: linear-gradient(180deg, rgba(20,14,10,0.15) 0%, rgba(20,14,10,0.55) 100%), url('<?php echo e(asset('images/stock/'.$slide['image'])); ?>');">

                <div class="mx-auto flex h-full max-w-6xl flex-col justify-center px-6">
                    <p class="text-xs font-medium uppercase tracking-[0.3em] text-white/70">Septyaa Beauty Bar</p>
                    <h1 class="mt-3 max-w-xl font-serif text-4xl font-semibold text-white sm:text-6xl"><?php echo e($slide['title']); ?></h1>
                    <p class="mt-4 text-sm text-white/80 sm:text-base"><?php echo e($slide['subtitle']); ?></p>

                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="<?php echo e($slide['primaryRoute']); ?>"
                           class="rounded-full bg-accent px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white transition hover:bg-accent-dark">
                            <?php echo e($slide['primaryLabel']); ?>

                        </a>
                        <a href="<?php echo e($slide['secondaryRoute']); ?>"
                           class="rounded-full border border-white/70 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white transition hover:bg-white/10">
                            <?php echo e($slide['secondaryLabel']); ?>

                        </a>
                    </div>
                </div>
            </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <button type="button" data-slider-prev aria-label="Slide sebelumnya"
                class="absolute left-4 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/20 text-white backdrop-blur transition hover:bg-white/30 sm:left-8">
            &#10094;
        </button>
        <button type="button" data-slider-next aria-label="Slide berikutnya"
                class="absolute right-4 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/20 text-white backdrop-blur transition hover:bg-white/30 sm:right-8">
            &#10095;
        </button>

        <div class="absolute bottom-6 left-1/2 flex -translate-x-1/2 gap-2">
            <?php $__currentLoopData = $heroSlides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button" data-slide-dot="<?php echo e($index); ?>" aria-label="Ke slide <?php echo e($index + 1); ?>"
                        class="h-2.5 w-2.5 rounded-full transition <?php echo e($index === 0 ? 'bg-white' : 'bg-white/40'); ?>"></button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<script>
    (function () {
        const slider = document.querySelector('[data-hero-slider]');
        if (!slider) return;

        const slides = Array.from(slider.querySelectorAll('[data-slide]'));
        const dots = Array.from(slider.querySelectorAll('[data-slide-dot]'));
        const prevBtn = slider.querySelector('[data-slider-prev]');
        const nextBtn = slider.querySelector('[data-slider-next]');
        let current = 0;
        let timer = null;

        function show(index) {
            current = (index + slides.length) % slides.length;
            slides.forEach((slide, i) => {
                slide.classList.toggle('opacity-100', i === current);
                slide.classList.toggle('opacity-0', i !== current);
                slide.classList.toggle('pointer-events-none', i !== current);
            });
            dots.forEach((dot, i) => {
                dot.classList.toggle('bg-white', i === current);
                dot.classList.toggle('bg-white/40', i !== current);
            });
        }

        function startAutoplay() {
            stopAutoplay();
            timer = window.setInterval(() => show(current + 1), 5000);
        }
        function stopAutoplay() {
            if (timer) window.clearInterval(timer);
        }

        prevBtn.addEventListener('click', () => { show(current - 1); startAutoplay(); });
        nextBtn.addEventListener('click', () => { show(current + 1); startAutoplay(); });
        dots.forEach((dot, i) => dot.addEventListener('click', () => { show(i); startAutoplay(); }));

        slider.addEventListener('mouseenter', stopAutoplay);
        slider.addEventListener('mouseleave', startAutoplay);

        startAutoplay();
    })();
</script>


<section class="mx-auto max-w-6xl px-6 py-20">
    <div class="text-center">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-accent">Layanan Terkurasi</p>
        <h2 class="mt-3 font-serif text-3xl font-semibold text-ink">Perawatan yang terasa lembut, presisi, dan premium.</h2>
    </div>

    <div class="mt-10 grid gap-6 sm:grid-cols-2">
        <article class="group overflow-hidden rounded-2xl border border-line bg-surface">
            <div class="h-56 bg-cover bg-center transition duration-500 group-hover:scale-105"
                 style="background-image: linear-gradient(180deg, rgba(20,14,10,0.05) 0%, rgba(20,14,10,0.35) 100%), url('<?php echo e(asset('images/stock/service-nail.jpg')); ?>');"></div>
            <div class="p-6">
                <h3 class="font-serif text-lg font-semibold text-ink">Nail Art</h3>
                <p class="mt-2 text-sm text-ink-muted">Detail manicure dan gel polish dengan hasil rapi, glossy, dan tahan lama.</p>
                <a href="<?php echo e(route('services.index')); ?>" class="mt-3 inline-block text-sm font-medium text-accent hover:underline">Jelajahi &rarr;</a>
            </div>
        </article>

        <article class="group overflow-hidden rounded-2xl border border-line bg-surface">
            <div class="h-56 bg-cover bg-center transition duration-500 group-hover:scale-105"
                 style="background-image: linear-gradient(180deg, rgba(20,14,10,0.05) 0%, rgba(20,14,10,0.35) 100%), url('<?php echo e(asset('images/stock/service-face.jpg')); ?>');"></div>
            <div class="p-6">
                <h3 class="font-serif text-lg font-semibold text-ink">Face Treatment</h3>
                <p class="mt-2 text-sm text-ink-muted">Brightening facial dan skin ritual dengan tekstur lembut dan hasil segar.</p>
                <a href="<?php echo e(route('services.index')); ?>" class="mt-3 inline-block text-sm font-medium text-accent hover:underline">Jelajahi &rarr;</a>
            </div>
        </article>
    </div>
</section>


<section class="bg-surface py-20">
    <div class="mx-auto max-w-6xl px-6">
        <div class="flex items-end justify-between">
            <div>
                <p class="text-xs font-medium uppercase tracking-[0.3em] text-accent">Lihat Selengkapnya</p>
                <h2 class="mt-3 font-serif text-3xl font-semibold text-ink">Produk pilihan untuk sentuhan akhir yang bersih.</h2>
            </div>
            <a href="<?php echo e(route('products.index')); ?>" class="hidden text-sm font-medium text-accent hover:underline sm:block">Jelajahi Produk &rarr;</a>
        </div>

        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <?php $__currentLoopData = [
                ['image' => 'product-1.jpg', 'name' => 'Soft Cleanser', 'tag' => 'Calm skin wash'],
                ['image' => 'product-2.jpg', 'name' => 'Glow Essence', 'tag' => 'Daily prep layer'],
                ['image' => 'product-3.jpg', 'name' => 'Body Veil', 'tag' => 'Silky hydration'],
                ['image' => 'product-4.jpg', 'name' => 'Pure Serum', 'tag' => 'Bright finish'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="overflow-hidden rounded-2xl border border-line bg-white">
                    <div class="h-40 bg-cover bg-center" style="background-image: url('<?php echo e(asset('images/stock/'.$item['image'])); ?>');"></div>
                    <div class="p-4">
                        <h4 class="font-serif text-sm font-semibold text-ink"><?php echo e($item['name']); ?></h4>
                        <p class="mt-1 text-xs text-ink-muted"><?php echo e($item['tag']); ?></p>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>


<section class="mx-auto max-w-6xl px-6 py-20">
    <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
        <div>
            <p class="text-xs font-medium uppercase tracking-[0.3em] text-accent">Rasakan Rangkaiannya</p>
            <h2 class="mt-3 font-serif text-3xl font-semibold text-ink">Tempat di mana treatment terasa tenang sebelum terasa indah.</h2>
            <p class="mt-4 text-sm leading-relaxed text-ink-muted">
                Kami merancang setiap layanan agar terasa pelan, hangat, dan berkelas. Dari konsultasi singkat sampai
                finishing akhir, semuanya dibuat untuk pengalaman yang lebih personal.
            </p>

            <div class="mt-8 grid grid-cols-3 gap-4 border-t border-line pt-6">
                <div>
                    <p class="font-serif text-2xl font-semibold text-ink">500+</p>
                    <p class="text-xs text-ink-muted">klien yang puas</p>
                </div>
                <div>
                    <p class="font-serif text-2xl font-semibold text-ink">8+</p>
                    <p class="text-xs text-ink-muted">jam terbang</p>
                </div>
                <div>
                    <p class="font-serif text-2xl font-semibold text-ink">3</p>
                    <p class="text-xs text-ink-muted">Layanan Khas</p>
                </div>
            </div>
        </div>

        <div class="h-80 rounded-[34px] bg-cover bg-center shadow-lg lg:h-96"
             style="background-image: linear-gradient(180deg, rgba(255,248,240,0.1) 0%, rgba(92,62,42,0.25) 100%), url('<?php echo e(asset('images/stock/editorial.jpg')); ?>');"></div>
    </div>
</section>


<section class="pb-24">
    <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-6 rounded-3xl bg-ink px-8 py-10 text-center sm:flex-row sm:text-left">
        <div>
            <p class="text-xs font-medium uppercase tracking-[0.3em] text-white/60">MULAI PERAWATAN ANDA</p>
            <h3 class="mt-2 font-serif text-2xl font-semibold text-white">Siap untuk sesi perawatan berikutnya?</h3>
            <p class="mt-1 text-sm text-white/70">Pilih layanan favoritmu lalu atur jadwal yang paling nyaman.</p>
        </div>
        <a href="<?php echo e(route('booking.create')); ?>"
           class="shrink-0 rounded-full bg-accent px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white transition hover:bg-accent-dark">
            Mulai Pengalaman Anda
        </a>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/home.blade.php ENDPATH**/ ?>