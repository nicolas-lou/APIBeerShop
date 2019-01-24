<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 24/01/19
 * Time: 10:16
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Beer;



class BeerController extends Controller{

    /**
     * @Route("/beers", name="beers", methods={"GET"})
     *
     */
    public function beerAction(Request $request)
    {
        $beers = $this->getDoctrine()->getRepository(Beer::class)->findAll();
        foreach ($beers as $beer){
            $beersOk[]= [
                'id'=>$beer->getId(),
                'name'=>$beer->getName(),
                'price'=>$beer->getPrice(),
                'category'=>$beer->getCategory()->getName(),
                'brasseur'=>$beer->getBrasseur(),
                'info'=>$beer->getInfo(),
                'volume'=>$beer->getVolume(),
                'country'=>$beer->getCountry()
            ];
        }
        return new JsonResponse($beersOk);
    }


    /**
     * @Route("/getbeer/{id}", name="getbeer", requirements={"id"="\d+"}, methods={"GET"})
     *
     */
    public function getBeerAction($id)
    {
        $beer = $this->getDoctrine()->getRepository(Beer::class)->find($id);

        $beerOk=[
            'id'=>$beer->getId(),
            'name'=>$beer->getName(),
            'price'=>$beer->getPrice(),
            'category'=>$beer->getCategory()->getName(),
            'brasseur'=>$beer->getBrasseur(),
            'info'=>$beer->getInfo(),
            'volume'=>$beer->getVolume(),
            'country'=>$beer->getCountry()
        ];

        return new JsonResponse($beerOk);
    }

    /**
     * @Route("/addBeer", name="addBeer", methods={"POST"})
     *
     */
    public function addBeerAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $beer = new Beer();
        $variable= json_decode($request->getContent(), true);
        $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(array('name' => $variable['category']));
        if(!isset($category)){
            $category = new Category();
            $category->setName($variable['category']);
            $name = $variable['name'];
            $price = $variable['price'];
            $brasseur = $variable['brasseur'];
            $info = $variable['info'];
            $volume = $variable['volume'];
            $country = $variable['country'];
            $beer->setName($name)
                ->setPrice($price)
                ->setCategory($category)
                ->setBrasseur($brasseur)
                ->setInfo($info)
                ->setVolume($volume)
                ->setCountry($country);

            $entityManager->persist($category);
            $entityManager->persist($beer);
            $entityManager->flush();
        }else{
            $name = $variable['name'];
            $price = $variable['price'];
            $brasseur = $variable['brasseur'];
            $info = $variable['info'];
            $volume = $variable['volume'];
            $country = $variable['country'];
            $beer->setName($name)
                ->setPrice($price)
                ->setCategory($category)
                ->setBrasseur($brasseur)
                ->setInfo($info)
                ->setVolume($volume)
                ->setCountry($country);


            $entityManager->persist($beer);
            $entityManager->flush();
        }

        return new Response('Beer ok, id : '.$beer->getId());


    }

    /**
     * @Route("/deletebeer/{id}", name="deletebeer", requirements={"id"="\d+"}, methods={"DELETE"})
     *
     */
    public function deleteBeerAction($id)
    {
        $beer = $this->getDoctrine()->getRepository(Beer::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($beer);
        $entityManager->flush();

        return new Response('remove ok');
    }

    /**
     * @Route("/updatebeer/{id}", name="updatebeer", requirements={"id"="\d+"}, methods={"PUT"})
     *
     */
    public function updateBeerAction($id, Request $request)
    {
        $data = json_decode($request->getContent(),true);
        $beer = $this->getDoctrine()->getRepository(Beer::class)->find($id);
        if(isset($data['name'])){
            $beer->setName($data['name']);
        }
        if(isset($data['price'])){
            $beer->setPrice($data['price']);
        }
        if(isset($data['brasseur'])){
            $beer->setBrasseur($data['brasseur']);
        }
        if(isset($data['info'])){
            $beer->setInfo($data['info']);
        }
        if(isset($data['volume'])){
            $beer->setVolume($data['volume']);
        }
        if(isset($data['country'])){
            $beer->setCountry($data['country']);
        }


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return new Response('update ok');
    }


}