<?php namespace Projammer\Observers;

class RequirementObserver {

	public function saving($model) {

		if (!empty($model->code)) $model->code = strtoupper($model->code);
		if (!empty($model->name)) $model->name = ucfirst($model->name);

	}
}