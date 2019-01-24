<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 24/01/19
 * Time: 15:02
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Beer;
use AppBundle\Entity\User;
use AppBundle\Entity\Command;
use AppBundle\Entity\CommandDetails;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class CommandDetailsController extends Controller{

    /**
     * @Route("/addCommandProduct/{id}", name="addCommandProduct", requirements={"id"="\d+"} , methods={"POST"})
     *
     */
    public function addCommandProductAction(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $commandDetail = new CommandDetails();
        $variable= json_decode($request->getContent(), true);
        $command = $this->getDoctrine()->getRepository(Command::class)->find($id);
        $date = new DateTime("Now");
        $qty = $variable['qty'];
        $beer = $this->getDoctrine()->getRepository(Beer::class)->find($variable['beer'] );

        $commandDetail->setDate($date)
            ->setQty($qty)
            ->setCommand($command)
            ->setBeer($beer);

        $entityManager->persist($commandDetail);
        $entityManager->flush();


        return new Response('CommandDetail ok, id : '.$commandDetail->getId());
    }

    /**
     * @Route("/getAllProductCommand/{id}", name="getAllProductCommand", requirements={"id"="\d+"}, methods={"GET"})
     *
     */
    public function getAllProductCommandAction($id)
    {
        $commandDetails = $this->getDoctrine()->getRepository(Command::class)->find($id)->getCommanddetails();
        foreach ($commandDetails as $detail){
            $commandDetailsOk[]= [
                'id'=>$detail->getId(),
                'command'=>$detail->getCommand()->getId(),
                'date'=>$detail->getDate()->format("Y-m-d"),
                'qty'=>$detail->getQty(),
                'beer'=>$detail->getBeer()->getName()

            ];
        }
        return new JsonResponse($commandDetailsOk);
    }

}