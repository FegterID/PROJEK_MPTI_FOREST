<?php $__env->startSection('content'); ?>
<div class="grid min-h-screen lg:grid-cols-2">
    <div class="relative hidden overflow-hidden bg-ink lg:flex lg:items-center lg:justify-center bg-cover bg-center"
        style="background-image: url('<?php echo e(asset('images/stock/auth-panel.jpg')); ?>');">

        <div class="absolute inset-0 bg-gradient-to-br from-accent-dark via-ink to-ink opacity-70"></div>
    </div>

    <div class="relative flex items-center justify-center px-6 py-16">
        <a href="<?php echo e(route('home')); ?>"
           class="absolute right-6 top-6 text-2xl leading-none text-ink-muted transition hover:text-accent"
           aria-label="Kembali ke beranda">&times;</a>

        <div class="w-full max-w-sm">
            <p class="font-serif text-lg font-semibold text-ink"><?php echo e($siteConfig['name']); ?></p>


            <?php if($errors->any()): ?>
                <div class="mt-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login.attempt')); ?>" class="mt-6 space-y-5">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="login_id" class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">
                        Email
                    </label>
                    <input type="text" id="login_id" name="login_id" value="<?php echo e(old('login_id')); ?>" required
                           placeholder="Masukan Email"
                           class="mt-2 w-full rounded-lg border border-line bg-white px-4 py-2.5 text-sm text-ink focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">
                        Password
                    </label>
                    <input type="password" id="password" name="password" required placeholder="........"
                           class="mt-2 w-full rounded-lg border border-line bg-white px-4 py-2.5 text-sm text-ink focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                </div>

                <button type="submit"
                        class="w-full rounded-lg bg-accent py-3 text-sm font-medium text-white transition hover:bg-accent-dark">
                    Login
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-ink-muted">
                Belum Punya Akun?
                <a href="<?php echo e(route('register')); ?>" class="font-medium text-accent hover:underline">Register</a>
            </p>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/auth/login.blade.php ENDPATH**/ ?>