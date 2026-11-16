<?php


$p = $pagination;

if ($p['total'] === 0) return;

$query = $this->input->get() ?: array();
$link  = function ($page) use ($query) {
	$query['page'] = $page;
	return current_url() . '?' . http_build_query($query);
};

$window = 2;   // pages shown on each side of the current one
$start  = max(1, $p['current_page'] - $window);
$end    = min($p['last_page'], $p['current_page'] + $window);
?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
	<small class="text-secondary">
		Showing <?= $p['from'] ?> to <?= $p['to'] ?> of <?= $p['total'] ?> records
	</small>

	<?php if ($p['last_page'] > 1): ?>
	<nav aria-label="Pagination">
		<ul class="pagination pagination-sm mb-0">
			<li class="page-item<?= $p['has_prev'] ? '' : ' disabled' ?>">
				<a class="page-link" href="<?= $p['has_prev'] ? html_escape($link($p['current_page'] - 1)) : '#' ?>">&laquo;</a>
			</li>

			<?php if ($start > 1): ?>
				<li class="page-item"><a class="page-link" href="<?= html_escape($link(1)) ?>">1</a></li>
				<?php if ($start > 2): ?><li class="page-item disabled"><span class="page-link">…</span></li><?php endif; ?>
			<?php endif; ?>

			<?php for ($i = $start; $i <= $end; $i++): ?>
				<li class="page-item<?= $i === $p['current_page'] ? ' active' : '' ?>">
					<a class="page-link" href="<?= html_escape($link($i)) ?>"><?= $i ?></a>
				</li>
			<?php endfor; ?>

			<?php if ($end < $p['last_page']): ?>
				<?php if ($end < $p['last_page'] - 1): ?><li class="page-item disabled"><span class="page-link">…</span></li><?php endif; ?>
				<li class="page-item"><a class="page-link" href="<?= html_escape($link($p['last_page'])) ?>"><?= $p['last_page'] ?></a></li>
			<?php endif; ?>

			<li class="page-item<?= $p['has_next'] ? '' : ' disabled' ?>">
				<a class="page-link" href="<?= $p['has_next'] ? html_escape($link($p['current_page'] + 1)) : '#' ?>">&raquo;</a>
			</li>
		</ul>
	</nav>
	<?php endif; ?>
</div>
