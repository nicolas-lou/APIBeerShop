<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 24/01/19
 * Time: 13:39
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Command;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;



class CommandController extends Controller{

    /**
     * @Route("/addCommand/{id}", name="addCommand", requirements={"id"="\d+"} , methods={"POST"})
     *
     */
    public function addCommandAction(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $command = new Command();
        $variable= json_decode($request->getContent(), true);
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $date = new DateTime("Now");
        $total = $variable['total'];
        $status = $variable['status'];

        $command->setDate($date)
            ->setTotal($total)
            ->setStatus($status)
            ->setUser($user);

        $entityManager->persist($command);
        $entityManager->flush();


        return new Response('Command ok, id : '.$command->getId());
    }

    /**
     * @Route("/commands", name="commands", methods={"GET"})
     *
     */
    public function commandsAction(Request $request)
    {
        $commands = $this->getDoctrine()->getRepository(Command::class)->findAll();
        foreach ($commands as $command){
            $commandsOk[]= [
                'id'=>$command->getId(),
                'user'=>$command->getUser()->getId(),
                'date'=>$command->getDate()->format("Y-m-d"),
                'status'=>$command->getStatus(),
                'total'=>$command->getTotal()

            ];
        }
        return new JsonResponse($commandsOk);
    }


    /**
     * @Route("/getcommand/{id}", name="getcommand", requirements={"id"="\d+"}, methods={"GET"})
     *
     */
    public function getCommandAction($id)
    {
        $command = $this->getDoctrine()->getRepository(Command::class)->find($id);

        $commandOk=[
            'id'=>$command->getId(),
            'user'=>$command->getUser()->getId(),
            'date'=>$command->getDate()->format('Y-m-d'),
            'status'=>$command->getStatus(),
            'total'=>$command->getTotal()
        ];

        return new JsonResponse($commandOk);
    }

}