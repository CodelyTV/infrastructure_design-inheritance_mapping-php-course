<?php

declare(strict_types=1);

namespace CodelyTv\Tests\Mooc\Steps\Infrastructure\Persistence;

use CodelyTv\Tests\Mooc\Steps\Domain\Exercise\ExerciseStepMother;
use CodelyTv\Tests\Mooc\Steps\Domain\Quiz\QuizStepMother;
use CodelyTv\Tests\Mooc\Steps\Domain\Video\VideoStepMother;
use CodelyTv\Tests\Mooc\Steps\StepsModuleInfrastructureTestCase;

final class MySqlStepRepositoryTest extends StepsModuleInfrastructureTestCase
{
	/**
	 * @test
	 * @dataProvider steps
	 */
	public function it_should_save_an_step($step): void
	{
		$this->repository()->save($step);
	}

	/**
	 * @test
	 * @dataProvider steps
	 */
	public function it_should_search_an_existing_step($step): void
	{
		$this->repository()->save($step);

		$this->assertEquals($step, $this->repository()->search($step->id, get_class($step)));
	}

	/**
	 * @test
	 * @dataProvider steps
	 */
	public function it_should_delete_an_existing_step($step): void
	{
		$this->repository()->save($step);
		$this->repository()->delete($step);

		$this->assertNull($this->repository()->search($step->id, get_class($step)));
	}

	public function steps(): array
	{
		return [
			'video' => [VideoStepMother::create()],
			'exercise' => [ExerciseStepMother::create()],
			'quiz' => [QuizStepMother::create()],
		];
	}
}
