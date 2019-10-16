<?php

declare(strict_types=1);

namespace App\Presenters;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Nette;
use Nette\Application\Responses\CallbackResponse;
use Nette\Http\IRequest;
use Nette\Http\Response;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{

	/** @var Client */
	private $guzzle;


	public function __construct()
	{
		parent::__construct();
		$this->guzzle = new Client();
	}

	/**
	 * @param string $color
	 * @throws Nette\Application\AbortException
	 * @see http://localhost:82/test?color=black
	 */
	public function actionTest(string $color)
	{
		$registry = CollectorRegistry::getDefault();
		$counter = $registry->getOrRegisterCounter('testx', 'request_count', 'it increases', ['color']);
		$counter->inc([$color]);

		$this->sendJson(['status' => 'ok', 'color' => $color]);
	}

	public function actionMetrics()
	{
		$registry = CollectorRegistry::getDefault();

		$renderer = new RenderTextFormat();
		$result = $renderer->render($registry->getMetricFamilySamples());

		$this->sendResponse(new CallbackResponse(
				function (IRequest $request, Response $response) use ($result) {
					$response->setContentType(RenderTextFormat::MIME_TYPE);
					echo $result;
				}
			)
		);
	}

	public function actionDefault()
	{
		$request = new Request('GET', 'http://symfony/article');
		$response = $this->guzzle->send($request);
		$articles = \json_decode((string)$response->getBody(), true);
		$this->template->articles = $articles;
	}

	public function actionDetail($id)
	{
		$response = $this->guzzle->get('http://symfony/article/' . $id);
		$article = \json_decode((string)$response->getBody(), true);
		$this->template->article = $article;
	}
}
