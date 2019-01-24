<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 24/01/19
 * Time: 10:34
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Entity\Beer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Category;


class CategoryController extends Controller{

    /**
     * @Route("/categories", name="categories", methods={"GET"})
     *
     */
    public function categoriesAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        foreach ($categories as $cat){
            $categoriesOk[]= [
                'id'=>$cat->getId(),
                'name'=>$cat->getName(),

            ];
        }
        return new JsonResponse($categoriesOk);
    }

    /**
     * @Route("/getcategory/{id}", name="getcategory", requirements={"id"="\d+"}, methods={"GET"})
     *
     */
    public function getCategoryAction($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        $categoryOk=[
            'id'=>$category->getId(),
            'name'=>$category->getName()
        ];

        return new JsonResponse($categoryOk);
    }

    /**
     * @Route("/getAllBeersOfCat/{id}", name="getcategory", requirements={"id"="\d+"}, methods={"GET"})
     *
     */
    public function getAllBeersOfCatAction($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $beers = $this->getDoctrine()->getRepository(Beer::class)->findBy(array('category' => $category));
        if(!is_null($beers)){
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
        }else{
            return new Response('not found');
        }


    }

    /**
     * @Route("/addCategory", name="addCategory", methods={"POST"})
     *
     */
    public function addCategoryAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = new Category();
        $variable= json_decode($request->getContent(), true);
        $name = $variable['name'];
        $category->setName($name);
        $entityManager->persist($category);
        $entityManager->flush();
        return new Response('Category ok, id : '.$category->getId());


    }

    /**
     * @Route("/deletecategory/{id}", name="deletecategory", requirements={"id"="\d+"}, methods={"DELETE"})
     *
     */
    public function deleteCategoryAction($id)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();

        return new Response('remove ok');
    }


}