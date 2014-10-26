<?php
$statusClass = "primary"; 
switch ($project->status) {
	case "presales":
		$statusClass="info";
	break;

	case "planning":
	case "development":
	case "uat":
	case "beta":
		$statusClass="warning";
	break;

	case "live":
		$statusClass="success";
	break;

	case "snagging":
		$statusClass="danger";
	break;

	case "cancelled":
	case "archived":
	default:
	$statusClass = "default";
}
?>

<h1><?= $project->name; ?> <span class="label label-<?= $statusClass; ?>"><?= ucfirst($project->status); ?></span></h1>
<p><?= $project->description; ?></p>
<p>Created by <?= $project->creator->display_name ?> <?= $creationDate->diffInDays()>30 ? "on ".$creationDate->format('l jS \\of F Y h:i:s A') : $creationDate->diffForHumans() ?>
