<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 24/01/19
 * Time: 11:43
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Beer;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Category;


class UserController extends Controller{

    /**
     * @Route("/addUser", name="addUser", methods={"POST"})
     *
     */
    public function addUserAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $variable= json_decode($request->getContent(), true);

        $name = $variable['name'];
        $firstname = $variable['firstname'];
        $age = $variable['age'];
        $user->setName($name)
            ->setFirstname($firstname)
            ->setAge($age);

            $entityManager->persist($user);
            $entityManager->flush();


        return new Response('User ok, id : '.$user->getId());

    }

    /**
     * @Route("/getuser/{id}", name="getuser", requirements={"id"="\d+"}, methods={"GET"})
     *
     */
    public function getUserAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $userOk=[
            'id'=>$user->getId(),
            'name'=>$user->getName(),
            'firstname'=>$user->getFirstname(),
            'age'=>$user->getAge()

        ];

        return new JsonResponse($userOk);
    }


    /**
     * @Route("/users", name="users", methods={"GET"})
     *
     */
    public function usersAction(Request $request)
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        foreach ($users as $user){
            $usersOk[]= [
                'id'=>$user->getId(),
                'name'=>$user->getName(),
                'firstname'=>$user->getFirstname(),
                'age'=>$user->getAge()

            ];
        }
        return new JsonResponse($usersOk);
    }


    /**
     * @Route("/deleteUser/{id}", name="deleteUser", requirements={"id"="\d+"}, methods={"DELETE"})
     *
     */
    public function deleteUserAction($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return new Response('remove ok');
    }

    /**
     * @Route("/updateUser/{id}", name="updateUser", requirements={"id"="\d+"}, methods={"PUT"})
     *
     */
    public function updateUserAction($id, Request $request)
    {
        $data = json_decode($request->getContent(),true);
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        if(isset($data['name'])){
            $user->setName($data['name']);
        }
        if(isset($data['firstname'])){
            $user->setFirstname($data['firstname']);
        }
        if(isset($data['age'])){
            $user->setAge($data['age']);
        }


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return new Response('update ok');
    }

}