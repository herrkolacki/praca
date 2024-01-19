<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\PositionRepository;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class CompanyController extends AbstractController
{
    // #[Route('/company', name: 'app_company')]
    #[Route('/', name: 'homepage')]
    public function index(Request $request, Environment $twig, CompanyRepository $companyRepository): Response
    {
     
       /* var_dump($companyRepository->skarb('(())*(((()))'));        
         $orderItems[0]['ilosc'] = 0;
       $orderItems[0]['cena_szt'] = 10;
       $orderItems[0]['id_towaru'] = 1;
       
       $orderItems[1]['ilosc'] = 20;
       $orderItems[1]['cena_szt'] = 20;
       $orderItems[1]['id_towaru'] = 2;

       $orderItems[2]['ilosc'] = 30;
       $orderItems[2]['cena_szt'] = 30;
       $orderItems[2]['id_towaru'] = 3;

       $orderItems[3]['ilosc'] = 40;
       $orderItems[3]['cena_szt'] = 40;
       $orderItems[3]['id_towaru'] = 4;

        var_dump($companyRepository->calculateDeliveryCosts($orderItems, 10.10));
        die();
        print_r($companyRepository->boldWords('<p>cos</p> <p>nic</p> <p>wszy lawa</p> <b><p>zmo</p></b>', ['cos','nic', 'zmo', 'lawa']));*/
        //companies czyta z eventSubscribers
        return $this->render('company/index.html.twig', []);
                       //    'companies' => $companyRepository->findAll(),
                       //]);
        



       /* $offset = max(0, $request->query->getInt('offset', 0));
        
+       $paginator = $companyRepository->getCompanyPaginator(3);    

        return new Response($twig->render('company/index.html.twig', [
                        'companies' => $paginator,
                        'previous' => $offset - CompanyRepository::PAGINATOR_PER_PAGE,
                        'next' => min(count($paginator), $offset + CompanyRepository::PAGINATOR_PER_PAGE),
            ]));*/
    }
        
    #[Route('/company/{id}', name: 'app_company')]
    public function show(Environment $twig, Company $company, PositionRepository $positionRepository): Response
    {
            return new Response($twig->render('company/show.html.twig', [
               'company' => $company,
               'positions' => $positionRepository->findBy(['company' => $company], ['date' => 'DESC']),
            ]));
    }


    

}

