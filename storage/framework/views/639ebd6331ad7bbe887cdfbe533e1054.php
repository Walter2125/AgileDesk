<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['breadcrumbs' => []]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['breadcrumbs' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php if(is_array($breadcrumbs) && count($breadcrumbs)): ?>
<nav aria-label="breadcrumb" class="mb-3 mt-2">
  <ol class="breadcrumb bg-white rounded shadow-sm px-3 py-2">
    <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php if(!$loop->last): ?>
        <li class="breadcrumb-item">
          <a href="<?php echo e($item['url'] ?? '#'); ?>" class="text-decoration-none">
            <?php echo e($item['label']); ?>

          </a>
        </li>
      <?php else: ?>
        <li class="breadcrumb-item active" aria-current="page">
          <?php echo e($item['label']); ?>

        </li>
      <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </ol>
</nav>
<?php endif; ?><?php /**PATH C:\Users\gutya\Desktop\AgileDesk\resources\views/components/breadcrumbs.blade.php ENDPATH**/ ?>