<?php

namespace App\Controller;
use App\Repository\BurgerRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
 
// envoi de la réponse au navigateur
       return $this->render('home.html.twig');
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DefaultController.php',
        ]);
    }
    
       /**
     * @Route("/listJson", name="listJson",   format="json")
     */
    public function gfetListBurgers(BurgerRepository $burgerRepository)
    {
        $jsonEncoder = new JsonEncoder(); 
//         $v  =$burgerRepository->findBy('name')->OrderBy('name');
        
       $ob = $burgerRepository->findAll();
         $v3 =  $jsonEncoder->encode($ob, $format = 'json');
          
           
         $arr  =$burgerRepository->findBy(array(), array('name' => 'ASC'));
         $aBurgerS = [];
         foreach ($arr as $un) {
            $a = [];
            $a['name'] = $un->getName();
            $a['description'] = $un->getDescription();
            $a['price'] = $un->getPrice();
             $a['supp_double'] = $un->getsuppDouble();
           // $aBurgerS[$un->getId()]= $a;
            array_push ($aBurgerS , $a);
             
         }
//          $v5 =  $jsonEncoder->encode($aBurgerS, $format = 'json');
          $v5 = json_encode ($aBurgerS );
          
          $response = new JsonResponse($v5);

return $response;
          
          
             
    }
}
