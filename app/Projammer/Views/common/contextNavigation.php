<div id="contextNavigation">
<ul class="nav nav-pills nav-justified" role="tablist">
	<li<?= $active=="definition" ? " class='active'" : ""; ?>><a href="#">Definition</a></li>
	<li<?= $active=="requirements" ? " class='active'" : ""; ?>><a href="/project/<?= $project->id; ?>/requirements">Requirements</a></li>
	<li<?= $active=="deliverables" ? " class='active'" : ""; ?>><a href="#">Deliverables</a></li>
	<li<?= $active=="iterations" ? " class='active'" : ""; ?>><a href="#">Iterations</a></li>
	<li<?= $active=="artefacts" ? " class='active'" : ""; ?>><a href="#">Artefacts</a></li>
</ul>
</div>