<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Steps\Domain;

use CodelyTv\Mooc\Steps\Domain\Exercise\ExerciseStep;
use CodelyTv\Mooc\Steps\Domain\Quiz\QuizStep;
use CodelyTv\Mooc\Steps\Domain\Video\VideoStep;
use CodelyTv\Shared\Domain\Aggregate\AggregateRoot;

abstract class Step extends AggregateRoot
{
	public function __construct(
		public readonly StepId $id,
		protected readonly StepTitle $title,
		protected readonly StepDuration $duration
	) {}

	abstract public function toPrimitives(): array;

	public static function fromPrimitives(array $values): self
	{
		return match ($values['type']) {
			'video' => VideoStep::fromPrimitives($values),
			'quiz' => QuizStep::fromPrimitives($values),
			'exercise' => ExerciseStep::fromPrimitives($values),
		};
	}
}
