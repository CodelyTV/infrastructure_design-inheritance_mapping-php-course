<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Steps\Domain\Quiz;

final readonly class QuizStepQuestion
{
	public function __construct(private string $question, private array $answers) {}

	public static function fromString(string $value): self
	{
		[$question, $answers] = explode('----', $value);

		return new self($question, explode('****', $answers));
	}

	public function toString(): string
	{
		return $this->question . '----' . implode('****', $this->answers);
	}

	public static function fromPrimitives(array $question): self
	{
		return new self($question['question'], $question['answers']);
	}

	public function toPrimitives(): array
	{
		return [
			'question' => $this->question,
			'answers' => $this->answers,
		];
	}
}
