<?php

namespace App\DataFixtures;

use App\Entity\Poster;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadPosters($manager);
    }

    public function loadPosters(ObjectManager $manager)
    {
        $user = $this->getReference('admin');

        $poster = new Poster();
        $poster->setTitle('A first post!');
        $poster->setPublishedAt(new \DateTime('2020-03-01 12:00:00'));
        $poster->setDescription('First post for testing');
        $poster->setAuthor($user);

        $manager->persist($poster);

        $manager->flush();
    }

    public function loadComments(ObjectManager $manager)
    {

    }

    public function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('bekanur98@bk.ru');
        $user->setName('Beknur Baltabaev');

        $user->setPassword($this->passwordEncoder->encodePassword($user,'admin'));

        $this->addReference('admin', $user);

        $manager->persist($user);
        $manager->flush();
    }
}
