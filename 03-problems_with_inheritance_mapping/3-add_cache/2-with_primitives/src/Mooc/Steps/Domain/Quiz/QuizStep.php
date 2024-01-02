<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Steps\Domain\Quiz;

use CodelyTv\Mooc\Steps\Domain\Step;
use CodelyTv\Mooc\Steps\Domain\StepDuration;
use CodelyTv\Mooc\Steps\Domain\StepId;
use CodelyTv\Mooc\Steps\Domain\StepTitle;
use function Lambdish\Phunctional\map;

final class QuizStep extends Step
{
	/** @var QuizStepQuestion[] */
	private array $questions;

	public function __construct(
		StepId $id,
		StepTitle $title,
		StepDuration $duration,
		QuizStepQuestion ...$questions
	) {
		parent::__construct($id, $title, $duration);

		$this->questions = $questions;
	}

	public function toPrimitives(): array
	{
		return [
			'id' => $this->id->value(),
			'type' => 'quiz',
			'title' => $this->title->value(),
			'duration' => $this->duration->value(),
			'questions' => map(static fn (QuizStepQuestion $question) => $question->toPrimitives(), $this->questions),
		];
	}

	public static function fromPrimitives(array $primitives): self
	{
		return new self(
			new StepId($primitives['id']),
			new StepTitle($primitives['title']),
			new StepDuration($primitives['duration']),
			...map(static fn (array $question) => QuizStepQuestion::fromPrimitives($question), $primitives['questions'])
		);
	}
}
