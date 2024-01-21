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
        var_dump($companyRepository->findAllGreaterThanPrice('t'));

        return $this->render('company/index.html.twig', [
                           'companies' => $companyRepository->findByExampleField('tpay', 4)
                       ]);
        



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

