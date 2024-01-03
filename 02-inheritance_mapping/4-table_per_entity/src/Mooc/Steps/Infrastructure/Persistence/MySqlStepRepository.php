<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Steps\Infrastructure\Persistence;

use CodelyTv\Mooc\Steps\Domain\Exercise\ExerciseStep;
use CodelyTv\Mooc\Steps\Domain\Quiz\QuizStep;
use CodelyTv\Mooc\Steps\Domain\StepId;
use CodelyTv\Mooc\Steps\Domain\StepRepository;
use CodelyTv\Mooc\Steps\Domain\Video\VideoStep;
use CodelyTv\Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

final class MySqlStepRepository extends DoctrineRepository implements StepRepository
{
	public function save(ExerciseStep|QuizStep|VideoStep $step): void
	{
		$this->persist($step);
	}

	public function search(StepId $id, string $type): ExerciseStep|QuizStep|VideoStep|null
	{
		return $this->repository($type)->find($id);
	}

	public function delete(ExerciseStep|QuizStep|VideoStep $step): void
	{
		$this->remove($step);
	}
}
