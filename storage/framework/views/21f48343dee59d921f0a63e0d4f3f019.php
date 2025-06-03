<div class="users-table-container">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Seleccionar</th>
                <th>Nombre</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($user->usertype !== 'admin'): ?>
                <tr>
                    <td>
                        <input type="checkbox"
                            class="user-checkbox"
                            value="<?php echo e($user->id); ?>"
                            <?php echo e(in_array($user->id, $selectedUsers) ? 'checked' : ''); ?>>
                    </td>
                    <td><?php echo e($user->name); ?></td>
                    <td><?php echo e($user->email); ?></td>
                </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php /**PATH C:\Users\trimi\AgileDesk\resources\views/projects/partials/users_table.blade.php ENDPATH**/ ?>