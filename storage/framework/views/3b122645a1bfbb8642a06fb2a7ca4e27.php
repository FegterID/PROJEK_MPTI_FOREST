<?php $__env->startSection('title', 'Akun Saya'); ?>

<?php $__env->startSection('content'); ?>
<section class="mx-auto max-w-4xl px-6 py-16">
    <h1 class="font-serif text-3xl font-semibold text-ink">Akun Saya</h1>
    <p class="mt-2 text-sm text-ink-muted">Data diri pelanggan dari proses registrasi.</p>

    <?php if(session('success')): ?>
        <div class="mt-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <div class="mt-8 grid gap-6">
        
        <div class="rounded-xl border border-line bg-surface p-6">
            <h2 class="font-serif text-lg font-semibold text-ink">Ringkasan Akun</h2>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-xs uppercase tracking-wide text-ink-muted">Nama</p>
                    <p class="mt-1 text-sm text-ink"><?php echo e($user->name); ?></p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-ink-muted">Email</p>
                    <p class="mt-1 text-sm text-ink"><?php echo e($user->email); ?></p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-ink-muted">No. HP</p>
                    <p class="mt-1 text-sm text-ink"><?php echo e($user->username); ?></p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-ink-muted">Bergabung</p>
                    <p class="mt-1 text-sm text-ink"><?php echo e($user->created_at->translatedFormat('d M Y, H:i')); ?></p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs uppercase tracking-wide text-ink-muted">Alamat</p>
                    <p class="mt-1 whitespace-pre-line text-sm text-ink"><?php echo e($user->address); ?></p>
                </div>
            </div>
        </div>

        
        <div class="rounded-xl border border-line bg-surface p-6">
            <h2 class="font-serif text-lg font-semibold text-ink">Edit Profil</h2>
            <p class="mt-1 text-sm text-ink-muted">Perbarui data diri pelanggan Anda.</p>

            <form method="POST" action="<?php echo e(route('account.update')); ?>" class="mt-4 grid gap-4 sm:grid-cols-2">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Nama Lengkap</label>
                    <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" required
                           class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required
                           class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">No. HP (Username)</label>
                    <input type="text" name="phone" value="<?php echo e(old('phone', $user->username)); ?>" required
                           class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Alamat</label>
                    <textarea name="address" rows="1" required
                              class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20"><?php echo e(old('address', $user->address)); ?></textarea>
                </div>
                <div class="sm:col-span-2">
                    <button type="submit" class="rounded-full bg-accent px-6 py-2.5 text-sm font-medium text-white hover:bg-accent-dark">
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>

        
        <div class="rounded-xl border border-line bg-surface p-6">
            <h2 class="font-serif text-lg font-semibold text-ink">Keamanan</h2>
            <p class="mt-1 text-sm text-ink-muted">Kelola akses akun Anda.</p>

            <form method="POST" action="<?php echo e(route('account.password')); ?>" class="mt-4 grid gap-4 sm:grid-cols-3">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Password Lama</label>
                    <input type="password" name="current_password" required
                           class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Password Baru</label>
                    <input type="password" name="new_password" required
                           class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-ink-muted">Konfirmasi Password Baru</label>
                    <input type="password" name="confirm_password" required
                           class="mt-2 w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:border-accent focus:outline-none focus:ring-2 focus:ring-accent/20">
                </div>
                <div class="sm:col-span-3">
                    <button type="submit" class="rounded-full bg-accent px-6 py-2.5 text-sm font-medium text-white hover:bg-accent-dark">
                        Ubah Password
                    </button>
                </div>
            </form>

            <form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-4 border-t border-line pt-4">
                <?php echo csrf_field(); ?>
                <button type="submit" class="text-sm text-ink-muted hover:text-accent">Logout akun</button>
            </form>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/account/edit.blade.php ENDPATH**/ ?>