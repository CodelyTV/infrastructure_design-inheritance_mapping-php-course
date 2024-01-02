<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Steps\Domain;

use CodelyTv\Shared\Domain\Aggregate\AggregateRoot;

abstract class Step extends AggregateRoot
{
	public function __construct(
		public readonly StepId $id,
		protected readonly StepTitle $title,
		protected readonly StepDuration $duration
	) {}
}
