<div class="wrap">
    <h2>Milestones Options</h2>
    <form method="POST" action="options.php">
        <?php
        settings_fields('milestones');
        do_settings_sections('milestones');
        submit_button();
        ?>
    </form>

    <h2>Cached repositories</h2>

    <?php if ($repositories): ?>
    <ul>
        <?php foreach ($repositories as $name => $key): ?>
        <li><?= $name ?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="ms_clear_cache" />
        <?php submit_button('Delete Cache', 'delete') ?>
    </form>
</div>
