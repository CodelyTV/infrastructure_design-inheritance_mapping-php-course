<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Steps\Domain\Video;

use CodelyTv\Mooc\Steps\Domain\Step;
use CodelyTv\Mooc\Steps\Domain\StepDuration;
use CodelyTv\Mooc\Steps\Domain\StepId;
use CodelyTv\Mooc\Steps\Domain\StepTitle;

final class VideoStep extends Step
{
	public function __construct(
		StepId $id,
		StepTitle $title,
		StepDuration $duration,
		private readonly VideoStepUrl $url
	) {
		parent::__construct($id, $title, $duration);
	}

	public function toPrimitives(): array
	{
		return [
			'id' => $this->id->value(),
			'type' => 'video',
			'title' => $this->title->value(),
			'duration' => $this->duration->value(),
			'url' => $this->url->value(),
		];
	}

	public static function fromPrimitives(array $primitives): self
	{
		return new self(
			new StepId($primitives['id']),
			new StepTitle($primitives['title']),
			new StepDuration($primitives['duration']),
			new VideoStepUrl($primitives['url'])
		);
	}
}
