<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Psr\Log\LoggerInterface;

class UserController extends AbstractController
{

    /**
     * @Rest\Post("/user/")
     * @Rest\Post("/user")
     */
    public function create(SerializerInterface $serializer, Request $request, ObjectManager $em)
    {
        $data = $request->getContent();
        
        $user = $serializer->deserialize($data, User::class, 'json');
        $user->setCreatedAt(new \DateTime())
             ->setUpdatedAt(new \DateTime());
        
        $em->persist($user);
        $em->flush();
        
        return new Response('User created', Response::HTTP_CREATED);
    }

    /**
     * @Rest\Put("/user/{id}")
     * @Rest\Patch("/user/{id}")
     */
    public function edit(Request $request, ObjectManager $em, UserRepository $repository, $id)
    {
        $user = $repository->find($id);
        if ($user === null) {
            return new Response('User not found', Response::HTTP_NOT_FOUND);
        }
        
        $user->setLastname($request->get('lastname'));
        $user->setFirstname($request->get('firstname'));
        $user->setUpdatedAt(new \DateTime());
                
        $em->persist($user);
        $em->flush();
        
        return new Response('User modified', Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/user/{id}")
     */
    public function show(SerializerInterface $serializer, UserRepository $repository, $id)
    {
        $user = $repository->find($id);
        if ($user === null) {
            return new Response('User not found', Response::HTTP_NOT_FOUND);
        }

        $data = $serializer->serialize($user, 'json');
        $response = new Response($data, Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }

    /**
     * @Rest\Get("/user")
     */
    public function index(SerializerInterface $serializer, ObjectManager $em, UserRepository $repository)
    {
        
        $users = $repository->findAll();
        if ($users === null) {
            return new Response('User not found', Response::HTTP_NOT_FOUND);
        }

        $data = $serializer->serialize($users, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }

    /**
     * @Rest\Delete("/user/{id}")
     */
    public function delete(Request $request, ObjectManager $em, UserRepository $repository, $id)
    {
        $user = $repository->find($id);
        if ($user === null) {
            return new Response('User not found', Response::HTTP_NOT_FOUND);
        }

        $em->remove($user);
        $em->flush();
        
        return new Response('User deleted', Response::HTTP_OK);
    }

}
