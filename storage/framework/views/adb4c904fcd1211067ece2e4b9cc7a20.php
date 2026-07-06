<footer class="mt-24 border-t border-line bg-surface">
    <div class="mx-auto grid max-w-6xl gap-8 px-6 py-12 sm:grid-cols-3">
        <div>
            <p class="font-serif text-xl font-semibold text-ink"><?php echo e($siteConfig['name']); ?></p>
            <p class="mt-2 text-sm text-ink-muted"><?php echo e($siteConfig['address']); ?></p>
        </div>
        <div class="text-sm text-ink-muted">
            <p class="font-medium text-ink">Kontak</p>
            <p class="mt-2"><?php echo e($siteConfig['phone']); ?></p>
            <a href="<?php echo e($siteConfig['whatsapp']); ?>" class="mt-1 block hover:text-accent">WhatsApp</a>
            <a href="<?php echo e($siteConfig['instagram']); ?>" class="mt-1 block hover:text-accent">Instagram</a>
        </div>
        <div class="text-sm text-ink-muted sm:text-right">
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e($siteConfig['name']); ?>.</p>
            <p>All rights reserved.</p>
        </div>
    </div>
</footer>
<?php /**PATH /home/afegter/Fegas/SMT6/PROJEK_MPTI_FOREST/resources/views/partials/footer.blade.php ENDPATH**/ ?>