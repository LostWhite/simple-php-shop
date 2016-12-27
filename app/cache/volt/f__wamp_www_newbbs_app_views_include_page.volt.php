
<div class="btn-group">
    <?= $this->tag->linkTo([$action, '<i class="icon-fast-backward"></i> 第一页', 'class' => 'btn']) ?>
    <?= $this->tag->linkTo([$action . '?page=' . $page->before, '<i class="icon-step-backward"></i> 上一页', 'class' => 'btn ']) ?>
    <?= $this->tag->linkTo([$action . '?page=' . $page->next, '<i class="icon-step-forward"></i> 下一页', 'class' => 'btn']) ?>
    <?= $this->tag->linkTo([$action . '?page=' . $page->last, '<i class="icon-fast-forward"></i> 最后一页', 'class' => 'btn']) ?>
    <span class="help-inline"><?= $page->current ?>/<?= $page->total_pages ?></span>
</div>