<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Steps\Domain;

use CodelyTv\Mooc\Steps\Domain\Exercise\ExerciseStep;
use CodelyTv\Mooc\Steps\Domain\Quiz\QuizStep;
use CodelyTv\Mooc\Steps\Domain\Video\VideoStep;

interface StepRepository
{
	public function save(ExerciseStep|QuizStep|VideoStep $step): void;

	public function search(StepId $id, string $type): ExerciseStep|QuizStep|VideoStep|null;

	public function delete(ExerciseStep|QuizStep|VideoStep $step): void;
}
