<?php

namespace App\DataFixtures;

use App\Article\Status;
use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Faker\Provider\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
    $faker = FakerFactory::create();
    $faker->addProvider(new FakerFactory($faker));

    $category = new Category();
    $category->setName('plat');
    $manager->persist($category);
    $category2 = new Category();
    $category2->setName('dessert');
    $manager->persist($category2);

    for ($i = 0; $i < 50; $i++) {
      $car = new Article();

      $car->setTitle($faker->randomElement())
        ->setContent($faker->numberBetween(2000, 250000))
        ->setTrending($faker->boolean(80))
        ->setStatus(
          $faker->numberBetween(Status::BRUILLON, Status::EN_STOCK)
        )
        ->setCategory($category);

      $manager->persist($car);
    }
        $manager->flush();
    }
}
