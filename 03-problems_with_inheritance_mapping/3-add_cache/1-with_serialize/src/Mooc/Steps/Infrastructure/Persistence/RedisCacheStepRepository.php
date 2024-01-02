<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Steps\Infrastructure\Persistence;

use CodelyTv\Mooc\Steps\Domain\Step;
use CodelyTv\Mooc\Steps\Domain\StepId;
use CodelyTv\Mooc\Steps\Domain\StepRepository;
use Predis\Client;

final readonly class RedisCacheStepRepository implements StepRepository
{
	public function __construct(private StepRepository $repository, private Client $redisClient) {}

	public function save(Step $step): void
	{
		$this->repository->save($step);
	}

	public function search(StepId $id): ?Step
	{
		$key = $this->keyFor($id);

		return $this->redisClient->exists($key) ? unserialize($this->redisClient->get($key)) : $this->searchAndCache($id);
	}

	public function delete(Step $step): void
	{
		$key = $this->keyFor($step->id);

		$this->repository->delete($step);
		$this->redisClient->del($key);
	}

	private function searchAndCache(StepId $id): ?Step
	{
		$step = $this->repository->search($id);

		if ($step !== null) {
			$key = $this->keyFor($id);
			$this->redisClient->set($key, serialize($step));
		}

		return $step;
	}

	private function keyFor(StepId $id): string
	{
		return sprintf('mooc.steps.%s', $id->value());
	}
}
