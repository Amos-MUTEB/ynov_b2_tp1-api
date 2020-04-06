<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Car;
use App\Form\ArticleType;
use App\Form\CarType;
use App\Repository\ArticleRepository;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ArticleController extends AbstractBaseController
{

    private $em;

  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }
  
   /**
   * @Route("/car", name="article_list", methods={"GET"})
   */
  public function list(
    ArticleRepository $ArticleRepository,
    SerializerInterface $serializer
  ) {
    $article = $ArticleRepository->findAll();

    return $this->json([
      'articles' => $article
    ]);
}

/**
   * @Route("/car/{id}", name="car_detail", methods={"GET"})
   */
  public function detail(Article $article)
  {
    return $this->json(
      ['car' => $article], // données à sérialiser
      Response::HTTP_OK, // Code de réponse HTTP
      [], // En-têtes
      ['groups' => 'car:detail'] // Contexte
    );
  }

  /**
   * @Route("/car", name="car_create", methods={"POST"})
   */
  public function create(
    Request $request
  ) {
    $data = json_decode($request->getContent(), true);
    $car = new Article();
    $form = $this->createForm(ArticleType::class, $car);

    // handleRequest ne va pas mapper les champs envoyés dans le corps de la requête. On ne va donc pas l'utiliser ici
    // $form->handleRequest($request);

    $form->submit($data);

    if ($form->isSubmitted() && $form->isValid()) {
      // On pourrait renseigner la date de création à ce niveau
      // Mais si on a besoin de créer une voiture ailleurs que dans ce contrôleur,
      // alors il faudra penser à renseigner la date de création.
      // On rique donc :
      // - d'oublier de renseigner cette date
      // - et, si on y pense, tout simplement de dupliquer notre code
      // $car->setCreated(new DateTime());
      $this->em->persist($car);
      $this->em->flush();

      return $this->json(
        $car,
        Response::HTTP_CREATED,
        [],
        ["groups" => "car:detail"]
      );

      $errors = $this->getFormErrors($form);
      return $this->json(
        $errors,
        Response::HTTP_BAD_REQUEST
      );
    }
  }

  
  /**
   * @Route("/car/{id}", name="car_patch", methods={"PATCH"})
   */
  public function patch(Article $article, Request $request)
  {
    return $this->update($request, $article, false);
  }

  /**
   * @Route("/car/{id}", name="car_put", methods={"PUT"})
   */
  public function put(Article $article, Request $request)
  {
    return $this->update($request, $article);
  }

   /**
   * @Route("/car/{id}", name="car_delete", methods={"DELETE"})
   */
  public function delete(Article $car)
  {
    $this->em->remove($car);
    $this->em->flush();

    return $this->json('ok');
  }

  private function update(
    Request $request,
    Article $article,
    bool $clearMissing = true
  ) {
    $data = json_decode($request->getContent(), true);
    $form = $this->createForm(ArticleType::class, $article);

    $form->submit($data, $clearMissing);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->em->flush();

      return $this->json($article);
    }

    $errors = $this->getFormErrors($form);
    return $this->json(
      $errors,
      Response::HTTP_BAD_REQUEST
    );
  }

}