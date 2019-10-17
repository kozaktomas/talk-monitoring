<?php

namespace App\Controller;

use App\Entity\Article;
use DataDog\DogStatsd;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FirstController extends AbstractFOSRestController
{

	/**
	 * @Rest\Get("/")
	 * @return JsonResponse
	 */
	public function index(): JsonResponse
	{
		$this->doMetricsMagic();
		$msg = 'metrics included';
		return $this->json(['status' => $msg]);
	}

	/**
	 * @see https://insights.eu.newrelic.com
	 * @see https://app.datadoghq.com/metric/explorer
	 */
	private function doMetricsMagic(): void
	{
		// new relic
		if (\extension_loaded('newrelic')) {
			newrelic_custom_metric('Custom/First/PeckaCounter', 1);
		}

		// datadog
		$statsd = new DogStatsd([
			'host' => \getenv('DD_AGENT_HOST'),
		]);
		$statsd->increment('test.demo.pecka.counter', 1, [
			'random_flag' => \rand(1, 2),
		]);
	}

	/**
	 * @Rest\Get("/article")
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function list(Request $request): JsonResponse
	{
		/** @var Article[] $articles */
		$articles = $this
			->getDoctrine()
			->getRepository(Article::class)
			->findAll();

		\usort($articles, function (Article $a, Article $b) {
			return $a->getId() > $b->getId();
		});

		$response = [];
		foreach ($articles as $article) {
			$response[] = [
				'id' => $article->getId(),
				'title' => $article->getTitle(),
			];
		}

		return $this->json($response);
	}

	/**
	 * @Rest\Get("/article/{id}")
	 * @param int $id
	 * @return JsonResponse
	 */
	public function detail(int $id): JsonResponse
	{
		/** @var Article $article */
		$article = $this
			->getDoctrine()
			->getRepository(Article::class)
			->find($id);

		if (!$article) {
			throw $this->createNotFoundException('Article not found');
		}

		$response = [
			'id' => $article->getId(),
			'title' => $article->getTitle(),
			'stars' => $article->getStars(),
		];

		return $this->json($response);
	}

}