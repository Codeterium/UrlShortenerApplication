<?php

namespace App\Controller;

use App\Form\ShortenType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Validation;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="index_route")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        $shortenService = $this->container->get('App\Services\Shorten');

        // New URL input form
        $form = $this->createForm(ShortenType::class);

        // Use only POST method request
        if ($request->isMethod('POST')) {
            // Collect data
            $form->handleRequest($request);
            // Validate submitted form
            if ($form->isSubmitted() && $form->isValid()) {
                // Get entered value of URL
                $submission = $form->getData();
                $url = $submission->getUrl();

                // Validator for Url
                $validator = Validation::createValidator();
                $errors = $validator->validate($url, [
                    new NotBlank(),
                    new Url(),
                ]);
                // Check for errors number
                if (0 !== count($errors)) {
                    foreach ($errors as $error) {
                        $this->addFlash("error", $error->getMessage());
                    }
                } else {
                    // Check if Url is exist
                    if ($shortenService->isExist($url)) {
                        $this->addFlash("error", "The URL you entered already exists");
                    } else {
                        // Create Url
                        $shorten = $shortenService->create($url);
                        $this->addFlash("success",  "Your shortened URL [" . $request->getHost() . "/" . $shorten->getUrl() . "]");
                        // Clear form
                        unset($form);
                        $form = $this->createForm(ShortenType::class);
                    }
                }
            } else {
                $this->addFlash("error", "Unable to shorten the entered URL");
            }
        }

        // Get full list of Urls
        $models = $shortenService->list();

        // Response view
        return $this->render('homepage.html.twig', [
            'form' => $form->createView(),
            'models' => $models,
        ]);
    }

    /**
     * @Route("/{code}", name="redirect_route", requirements={"code"="[A-Za-z0-9]{6}"})
     * @param String $code
     * @return Response
     */
    public function redirectAction($code): Response
    {
        $redirectUrl = '/';
        $shortenService = $this->container->get('App\Services\Shorten');
        $shorten = $shortenService->counter($code);
        if ($shorten) {
            $redirectUrl = $shorten->getUrl();
        } else {
            $this->addFlash("error", "Unable to resolve the entered code");
        }
        return $this->redirect($redirectUrl);
    }
}
