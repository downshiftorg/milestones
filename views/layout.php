<div class="milestones">
    <?php foreach($data as $id => $milestone): ?>
    <h2 class="milestones-title">
        <a target="_blank" href="<?= $milestone['html_url'] ?>">
            <?= $milestone['title'] ?>
        </a>
    </h2>
    <p>
        <?= $milestone['percent_complete'] ?>% complete
    </p>
    <ul class="milestones-issue-list">
        <?php foreach($milestone['issues'] as $issue): ?>
        <li class="milestones-issue-list__item milestones-issue-list__item--<?= $issue['state'] ?>">
            <a target="_blank" href="<?= $issue['html_url'] ?>">
                <?= $issue['title'] ?>
            </a>
        </li>
        <?php endforeach ?>
    </ul>
    <?php endforeach ?>
</div>
