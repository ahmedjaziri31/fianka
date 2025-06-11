<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Newsletter;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // User
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password123'));
        $manager->persist($user);

        // Category
        $category = new Category();
        $category->setName('T-Shirts');
        $category->setDescription('Casual T-Shirts');
        $manager->persist($category);

        // Product
        $product = new Product();
        $product->setName('Classic Tee');
        $product->setPrice(19.99);
        $product->setStock(100);
        $product->setCategory($category);
        $manager->persist($product);

        // Newsletter
        $newsletter = new Newsletter();
        $newsletter->setEmail('news@example.com');
        $newsletter->setUser($user);
        $manager->persist($newsletter);

        $manager->flush();
    }
}